<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Spryker\Zed\StockDataImport\Business\Writer;

use Orm\Zed\Stock\Persistence\SpyStock;
use Orm\Zed\Stock\Persistence\SpyStockQuery;
use Spryker\Zed\DataImport\Business\Exception\DataKeyNotFoundInDataSetException;
use Spryker\Zed\DataImport\Business\Model\DataImportStep\DataImportStepInterface;
use Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface;
use Spryker\Zed\StockDataImport\Business\Writer\DataSet\StockDataSetInterface;

class StockWriterStep implements DataImportStepInterface
{
    /**
     * @var string
     */
    protected const EXCEPTION_MESSAGE = '"%s" must be in the data set. Given: "%s"';

    /**
     * @param \Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface $dataSet
     *
     * @throws \Spryker\Zed\DataImport\Business\Exception\DataKeyNotFoundInDataSetException
     *
     * @return void
     */
    public function execute(DataSetInterface $dataSet): void
    {
        if (!$dataSet[StockDataSetInterface::COLUMN_NAME]) {
            throw new DataKeyNotFoundInDataSetException(sprintf(
                static::EXCEPTION_MESSAGE,
                StockDataSetInterface::COLUMN_NAME,
                implode(', ', array_keys($dataSet->getArrayCopy())),
            ));
        }

        $stockEntity = SpyStockQuery::create()
            ->filterByName($dataSet[StockDataSetInterface::COLUMN_NAME])
            ->findOneOrCreate();

        $this->saveStock($stockEntity, $dataSet);
    }

    /**
     * @param \Orm\Zed\Stock\Persistence\SpyStock $stockEntity
     * @param \Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface $dataSet
     *
     * @return void
     */
    protected function saveStock(SpyStock $stockEntity, DataSetInterface $dataSet): void
    {
        $stockEntity->fromArray($dataSet->getArrayCopy())->save();
    }
}
