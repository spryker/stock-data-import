<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Spryker\Zed\StockDataImport\Business\Writer;

use Orm\Zed\Stock\Persistence\SpyStockQuery;
use Orm\Zed\Stock\Persistence\SpyStockStore;
use Orm\Zed\Stock\Persistence\SpyStockStoreQuery;
use Spryker\Zed\DataImport\Business\Exception\EntityNotFoundException;
use Spryker\Zed\DataImport\Business\Model\DataImportStep\DataImportStepInterface;
use Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface;
use Spryker\Zed\StockDataImport\Business\Writer\DataSet\StockStoreDataSetInterface;

class StockStoreWriterStep implements DataImportStepInterface
{
    /**
     * @param \Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface $dataSet
     *
     * @throws \Spryker\Zed\DataImport\Business\Exception\EntityNotFoundException
     *
     * @return void
     */
    public function execute(DataSetInterface $dataSet): void
    {
        $stockEntity = SpyStockQuery::create()
            ->filterByIdStock($dataSet[StockStoreDataSetInterface::COLUMN_ID_STOCK])
            ->findOne();

        if ($stockEntity === null) {
            throw new EntityNotFoundException('Stock Entity not found');
        }

        $stockStoreEntity = SpyStockStoreQuery::create()
            ->filterByFkStore($dataSet[StockStoreDataSetInterface::COLUMN_ID_STORE])
            ->filterByFkStock($dataSet[StockStoreDataSetInterface::COLUMN_ID_STOCK])
            ->findOneOrCreate();

        if (!$stockStoreEntity->isNew()) {
            return;
        }

        $this->createStockStore($stockStoreEntity, $dataSet);
    }

    /**
     * @param \Orm\Zed\Stock\Persistence\SpyStockStore $stockStoreEntity
     * @param \Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface $dataSet
     *
     * @return void
     */
    protected function createStockStore(SpyStockStore $stockStoreEntity, DataSetInterface $dataSet): void
    {
        $stockStoreEntity->setFkStore($dataSet[StockStoreDataSetInterface::COLUMN_ID_STORE])
            ->setFkStock($dataSet[StockStoreDataSetInterface::COLUMN_ID_STOCK])
            ->save();
    }
}
