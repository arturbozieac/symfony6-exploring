<?php

namespace App\Book;

use App\Entity\Book;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

class BookManager implements ManagerInterface
{
    public function __construct(
        private readonly EntityManagerInterface $manager,
        #[Autowire(param: 'app.items_per_page')]
        private readonly int $itemsPerPage,
    ) {}

    public function fetchBook(string $title): Book
    {
        return $this->manager->getRepository(Book::class)->findOneBy(['title' => $title]);
    }

    public function fetchPaginated(int $page): iterable
    {
        return $this->manager
            ->getRepository(Book::class)
            ->findBy([], [], $this->itemsPerPage, ($page -1) * $this->itemsPerPage);
    }
}