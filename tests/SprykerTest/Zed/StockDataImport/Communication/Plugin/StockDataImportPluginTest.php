<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerTest\Zed\StockDataImport\Communication\Plugin;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\DataImporterConfigurationTransfer;
use Generated\Shared\Transfer\DataImporterReaderConfigurationTransfer;
use Spryker\Zed\StockDataImport\Communication\Plugin\StockDataImportPlugin;

/**
 * Auto-generated group annotations
 *
 * @group SprykerTest
 * @group Zed
 * @group StockDataImport
 * @group Communication
 * @group Plugin
 * @group StockDataImportPluginTest
 * Add your own group annotations below this line
 */
class StockDataImportPluginTest extends Unit
{
    /**
     * @var int
     */
    public const EXPECTED_IMPORT_COUNT = 3;

    /**
     * @var \SprykerTest\Zed\StockDataImport\StockDataImportCommunicationTester
     */
    protected $tester;

    /**
     * @return void
     */
    public function testImportImportsStock(): void
    {
        // Arrange
        $dataImporterReaderConfigurationTransfer = new DataImporterReaderConfigurationTransfer();
        $dataImporterReaderConfigurationTransfer->setFileName(codecept_data_dir() . 'import/warehouse.csv');
        $dataImportConfigurationTransfer = new DataImporterConfigurationTransfer();
        $dataImportConfigurationTransfer->setReaderConfiguration($dataImporterReaderConfigurationTransfer);
        $stockDataImportPlugin = new StockDataImportPlugin();

        // Act
        $dataImporterReportTransfer = $stockDataImportPlugin->import($dataImportConfigurationTransfer);

        // Assert
        $this->tester->assertStockTableContainsData();
        $this->assertSame(
            static::EXPECTED_IMPORT_COUNT,
            $dataImporterReportTransfer->getImportedDataSetCount(),
            sprintf(
                'Imported number of stocks is %s expected %s.',
                $dataImporterReportTransfer->getImportedDataSetCount(),
                static::EXPECTED_IMPORT_COUNT,
            ),
        );
    }
}
