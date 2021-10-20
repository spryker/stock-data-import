<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Spryker\Zed\StockDataImport\Business\Writer\DataSet;

interface StockStoreDataSetInterface
{
    /**
     * @var string
     */
    public const COLUMN_WAREHOUSE_NAME = 'warehouse_name';

    /**
     * @var string
     */
    public const COLUMN_STORE_NAME = 'store_name';

    /**
     * @var string
     */
    public const COLUMN_ID_STORE = 'fk_store';

    /**
     * @var string
     */
    public const COLUMN_ID_STOCK = 'fk_stock';
}
