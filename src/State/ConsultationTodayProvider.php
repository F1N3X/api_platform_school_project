<?php 
namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Repository\ConsultationRepository;

class ConsultationTodayProvider implements ProviderInterface
{
    private ConsultationRepository $repository;

    public function __construct(ConsultationRepository $repository)
    {
        $this->repository = $repository;
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): array
    {
        return $this->repository->findConsultationsToday() ?? [];
    }
}

?>