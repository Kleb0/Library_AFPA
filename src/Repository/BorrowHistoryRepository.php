<?php

namespace App\Repository;

use App\Entity\BorrowHistory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<BorrowHistory>
 *
 * @method BorrowHistory|null find($id, $lockMode = null, $lockVersion = null)
 * @method BorrowHistory|null findOneBy(array $criteria, array $orderBy = null)
 * @method BorrowHistory[]    findAll()
 * @method BorrowHistory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BorrowHistoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BorrowHistory::class);
    }

    /**
     * Enregistre ou met à jour une entité BorrowHistory
     */
    public function save(BorrowHistory $borrowHistory, bool $flush = false): void
    {
        $this->_em->persist($borrowHistory);

        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * Supprime une entité BorrowHistory
     */
    public function remove(BorrowHistory $borrowHistory, bool $flush = false): void
    {
        $this->_em->remove($borrowHistory);

        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * Trouve l'historique d'emprunts pour un utilisateur donné par son ID
     *
     * @param int $userId
     * @return BorrowHistory[]
     */
    public function findByUserId(int $userId): array
    {
        return $this->createQueryBuilder('bh')
            ->andWhere('bh.userId = :userId')
            ->setParameter('userId', $userId)
            ->orderBy('bh.borrowedAt', 'DESC')
            ->getQuery()
            ->getResult();
    }

    /**
     * Trouve tous les emprunts non retournés
     *
     * @return BorrowHistory[]
     */
    public function findUnreturnedBooks(): array
    {
        return $this->createQueryBuilder('bh')
            ->andWhere('bh.returnedAt IS NULL')
            ->orderBy('bh.borrowedAt', 'DESC')
            ->getQuery()
            ->getResult();
    }
}
