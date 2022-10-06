<?php

namespace App\Repositories;
use App\Core\Database;

abstract class AbstractRepository extends Database
{
    protected $table;

    public function findAll()
    {   
        return $this->findBy([], ['created_at' => 'DESC']);
    }

    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
    {
        $queryString = sprintf('SELECT * FROM %s', $this->table);
        
        if (0 < count($criteria)) {
            $loop = 0;
            
            foreach($criteria as $key => $value) {
                $queryString = sprintf('%s %s %s = "%s"', $queryString, 0 === $loop ? 'WHERE' : 'AND', $key, $value);

                $loop++;
            }
        }

        if (null !== $orderBy && 0 < count($orderBy)) {
            $loop = 0;

            foreach($orderBy as $key => $value) {
                $queryString = sprintf('%s %s %s %s', $queryString, 0 === $loop ? 'ORDER BY' : ',', $key, $value);

                $loop++;
            } 
        }

        if (null !== $limit) {
            $queryString = sprintf('%s LIMIT %s', $queryString, $limit);
        }

        if (null !== $offset) {
            $queryString = sprintf('%s OFFSET %s', $queryString, $offset);
        }

        $query = $this->getInstance()->prepare($queryString);
        $query->execute();

        return $query->fetchAll();
    }


    public function findItemBy(array $criteria = [], array $orderBy = [], int $offset = null) {
        $item = $this->findBy($criteria, $orderBy, 1, $offset);

        if (!empty($item)) {
            return $item;
        } else {
            return false;
        }
    }

    public static function slugify($text, string $divider = '-')
    {
        // replace non letter or digits by divider
        $text = preg_replace('~[^\pL\d]+~u', $divider, $text);

        // transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);

        // trim
        $text = trim($text, $divider);

        // remove duplicate divider
        $text = preg_replace('~-+~', $divider, $text);

        // lowercase
        $text = strtolower($text);

        if (empty($text)) {
            return 'n-a';
        }

        return $text;
    }
}