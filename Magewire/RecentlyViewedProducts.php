<?php declare(strict_types=1);

namespace YireoTraining\MagewireRecentlyViewedProducts\Magewire;

use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magewirephp\Magewire\Component;

class RecentlyViewedProducts extends Component
{
    public array $products = [];
    public array $productIds = [];

    protected $listeners = [
        'setProductIds' => 'setProductIds'
    ];

    public function __construct(
        private ProductRepositoryInterface $productRepository,
        private SearchCriteriaBuilder $searchCriteriaBuilder
    ) {
    }

    public function setProductIds(array $productIds = []): array
    {
        if (empty($productIds)) {
            return $productIds;
        }

        $this->searchCriteriaBuilder->setCurrentPage(0);
        $this->searchCriteriaBuilder->setPageSize(4);
        $this->searchCriteriaBuilder->addFilter('entity_id', $productIds, 'in');
        $searchResults = $this->productRepository->getList($this->searchCriteriaBuilder->create());
        $this->products = $searchResults->getItems();

        return $productIds;
    }
}
