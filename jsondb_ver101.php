<?php

class JsonDatabase
{
    private $filename;

    public function __construct($filename)
    {
        $this->filename = $filename;
    }

    private function loadData()
    {
        $data = file_get_contents($this->filename);
        return json_decode($data, true);
    }

    private function saveData($data)
    {
        $jsonData = json_encode($data, JSON_PRETTY_PRINT);
        file_put_contents($this->filename, $jsonData);
    }

    public function getAll($entity)
    {
        $data = $this->loadData();

        if (!isset($data[$entity])) {
            return [];
        }

        return $data[$entity];
    }

    public function getById($entity, $id)
    {
        $data = $this->loadData();

        if (!isset($data[$entity])) {
            return null;
        }

        $items = $data[$entity];

        foreach ($items as $item) {
            if ($item['id'] == $id) {
                return $item;
            }
        }

        return null;
    }

    public function create($entity, $item)
    {
        $data = $this->loadData();

        if (!isset($data[$entity])) {
            $data[$entity] = [];
        }

        $item['id'] = uniqid(); // Generate a unique ID (you may want to use a more robust method)

        $data[$entity][] = $item;

        $this->saveData($data);

        return $item;
    }

    public function update($entity, $id, $updatedItem)
    {
        $data = $this->loadData();

        if (!isset($data[$entity])) {
            return null;
        }

        $items = &$data[$entity];

        foreach ($items as &$item) {
            if ($item['id'] == $id) {
                $item = array_merge($item, $updatedItem);
                $this->saveData($data);
                return $item;
            }
        }

        return null;
    }

    public function delete($entity, $id)
    {
        $data = $this->loadData();

        if (!isset($data[$entity])) {
            return null;
        }

        $items = &$data[$entity];

        foreach ($items as $key => $item) {
            if ($item['id'] == $id) {
                unset($items[$key]);
                $this->saveData($data);
                return $item;
            }
        }

        return null;
    }

    // Left Join
    public function join($entity1, $entity2, $commonField)
    {
        $data = $this->loadData();
        $result = [];

        if (!isset($data[$entity1]) || !isset($data[$entity2])) {
            return [];
        }

        foreach ($data[$entity1] as $item1) {
            $matched = false;
            foreach ($data[$entity2] as $item2) {
                if ($item1[$commonField] == $item2[$commonField]) {
                    $result[] = array_merge($item1, $item2);
                    $matched = true;
                }
            }
            if (!$matched) {
                $result[] = array_merge($item1, array_fill_keys(array_keys(reset($data[$entity2])), null));
            }
        }

        return $result;
    }

    // Cross Join
    public function crossJoin($entity1, $entity2)
    {
        $data = $this->loadData();
        $result = [];

        if (!isset($data[$entity1]) || !isset($data[$entity2])) {
            return [];
        }

        foreach ($data[$entity1] as $item1) {
            foreach ($data[$entity2] as $item2) {
                $result[] = array_merge($item1, $item2);
            }
        }

        return $result;
    }

    // One-to-Many Relationship
    public function oneToMany($parentEntity, $childEntity, $parentKey, $childKey)
    {
        $data = $this->loadData();
        $result = [];

        if (!isset($data[$parentEntity]) || !isset($data[$childEntity])) {
            return [];
        }

        foreach ($data[$parentEntity] as $parentItem) {
            $matchedChildren = [];
            foreach ($data[$childEntity] as $childItem) {
                if ($parentItem[$parentKey] == $childItem[$childKey]) {
                    $matchedChildren[] = $childItem;
                }
            }
            $parentItem[$childEntity] = $matchedChildren;
            $result[] = $parentItem;
        }

        return $result;
    }

    // Export to CSV
    public function exportToCsv($entity)
    {
        $data = $this->loadData();

        if (!isset($data[$entity])) {
            return false;
        }

        $filename = $entity . '_export.csv';
        $fp = fopen($filename, 'w');

        $headerWritten = false;
        foreach ($data[$entity] as $row) {
            if (!$headerWritten) {
                fputcsv($fp, array_keys($row));
                $headerWritten = true;
            }
            fputcsv($fp, $row);
        }

        fclose($fp);

        return $filename;
    }
}
