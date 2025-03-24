<?php 
namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Repository\ConsultationRepository;

class ConsultationsTodayProvider implements ProviderInterface
{
    public function __construct(private ConsultationRepository $repository) {}

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): array
    {
        return $this->repository->findConsultationsToday();
    }
}
?>