<?php
declare(strict_types=1);

use Migrations\AbstractSeed;
use Src\Model\Table\BreedsTable;

/**
 * Breeds seed.
 */
class BreedsSeed extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeds is available here:
     * https://book.cakephp.org/phinx/0/en/seeding.html
     *
     * @return void
     */
    public function run()
    {
        $csvfile = new \SplFileObject(getcwd() .'/data/breeds.csv');

        $table = $this->table('breeds');

        $headers = ['name', 'image'];
        $data = [];

        foreach($csvfile as $key => $line) {
            if ($key === 0 || $line === "") {
                // Skip first row
                continue;
            }
            $segments = explode(',', $line);
            $segments[1] = trim($segments[1]);
            
            $data[] = array_combine($headers, $segments);
        }

        $table->insert($data)->save();
    }
}
