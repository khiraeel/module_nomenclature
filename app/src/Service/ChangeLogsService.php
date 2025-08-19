<?php

namespace App\Service;

use App\Entity\ChangeLogs;
use App\Repository\ChangeLogsRepository;
use Doctrine\ORM\EntityManagerInterface;
class ChangeLogsService
{
    public function __construct(
        private ChangeLogsRepository $changeLogsRepository,
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function addChangeLogs(ChangeLogs $changeLogs)
    {

    }

    public function getChangeLogs(): array
    {
        return $this->changeLogsRepository->findAll();
    }
}
