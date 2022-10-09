<?php

namespace App;

class TransactionsFileReader
{
    /* @var Transaction[] */
    private array $data = [];

    public function __construct(string $file)
    {
        if (!file_exists($file)) {
            throw new \Exception("File {$file} not found");
        }

        $content = file_get_contents($file);
        foreach (explode(PHP_EOL, $content) as $num => $line) {
            $item = json_decode($line);
            if (isset($item->bin) && isset($item->amount) && isset($item->currency)) {
                $this->data[] = new Transaction($item->bin, $item->amount, $item->currency);
            } else {
                throw new \Exception("Wrong data on line {$num}");
            }
        }
    }

    /**
     * @return Transaction[]
     */
    public function getData() : array
    {
        return $this->data;
    }
}
