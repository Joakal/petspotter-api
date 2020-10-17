<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\BreedsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\BreedsTable Test Case
 */
class BreedsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\BreedsTable
     */
    protected $Breeds;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Breeds',
        'app.Locations',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Breeds') ? [] : ['className' => BreedsTable::class];
        $this->Breeds = $this->getTableLocator()->get('Breeds', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Breeds);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
