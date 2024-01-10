<?php

namespace App\Security\Voter;

use App\Entity\Book;
use App\Entity\Movie;
use App\Entity\User;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class MovieRatingVoter extends Voter
{
    public const RATING = 'movie.rated';

    public function __construct(private EntityManagerInterface $entityManager)
    {
    }


    protected function supports(string $attribute, mixed $subject): bool
    {
        return ($subject instanceof Movie || null === $subject)
            && \in_array($attribute, [self::RATING]);
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        /**
         * @var Movie $subject
         */
        if (\in_array('ROLE_ADMIN', $token->getRoleNames())
            || $token->getUserIdentifier() === $subject->getCreatedBy()->getUserIdentifier()
        ) {

            return true;
        }

        $userRepository = $this->entityManager->getRepository(User::class);
        /** @var User $user */
        $user = $userRepository->findOneBy(['email' => $token->getUserIdentifier()]);

        $today = new \DateTime('today');
        $age = $user->getBirthday()->diff($today)->y;

        switch ($subject->getRated()) {
            case 'G':
                return true;
                break;
            case 'PG':
            case 'PG-13':
                return $age >= 13;
                break;
            case 'R':
            case 'NC-17':
                return $age >= 17;
                break;
        }

        return false;
    }
}
