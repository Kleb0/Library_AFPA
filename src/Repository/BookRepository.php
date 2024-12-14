<?php

namespace App\Repository;

use App\Entity\Book;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Book>
 *
 * @method Book|null find($id, $lockMode = null, $lockVersion = null)
 * @method Book|null findOneBy(array $criteria, array $orderBy = null)
 * @method Book[]    findAll()
 * @method Book[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BookRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Book::class);
    }

    /**
     * @param string $searchTerm
     * @return Book[]
     */
    public function searchBooks(string $searchTerm): array
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.title LIKE :searchTerm OR b.author LIKE :searchTerm')
            ->setParameter('searchTerm', '%' . $searchTerm . '%')
            ->orderBy('b.title', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Book[]
     */
    public function findAvailableBooks(): array
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.isAvailable = :available')
            ->setParameter('available', true)
            ->orderBy('b.title', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Book[]
     */
    public function findBooksByStatus(int $statusId): array
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.status = :status')
            ->setParameter('status', $statusId)
            ->orderBy('b.title', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function findNextCustomId(): int
    {
        $query = $this->createQueryBuilder('b')
            ->select('b.customId')
            ->orderBy('b.customId', 'ASC')
            ->getQuery();
    
        $existingIds = array_column($query->getResult(), 'customId');
    
        // Chercher le premier ID disponible
        $nextId = 1;
        while (in_array($nextId, $existingIds)) {
            $nextId++;
        }
    
        return $nextId;
    }

    public function findRandomBooks(int $limit = 5): array
    {
        $conn = $this->getEntityManager()->getConnection();

        // Injection directe de la valeur de la limite dans la requête
        $sql = 'SELECT * FROM book ORDER BY RAND() LIMIT ' . (int) $limit;

        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery();

        // Mapper les résultats pour retourner des objets Book
        $books = [];
        foreach ($resultSet->fetchAllAssociative() as $row) {
            $books[] = $this->getEntityManager()->getRepository(Book::class)->find($row['id']);
        }

        return $books;
    }


        
}
