<?php

namespace app\counter;

final class Counter
{
    public int $all = 0;

    public array $unique = [];

    public function countUniqueSum($provider, $uniqueField)
    {
//        $q_a = $provider->query;
        foreach ($provider->asArray()->all() as $q) {
            $this->all += 1;
            if (array_key_exists($q[$uniqueField], $this->unique)) {
                $this->unique[$q[$uniqueField]] += 1;
            } else {
                $this->unique[$q[$uniqueField]] = 1;
            }
        }
    }
}
