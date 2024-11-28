<?php

namespace App\Rules;

class PathReducer
{
    static function reduce(array|string $path, $data, bool $remove_null = false)
    {
        if (gettype($path) === 'string') {
            $path = explode('.', $path);
        }

        $reduced_data = PathReducer::_dfs($path, $data);

        if ($remove_null) {
            $reduced_data = array_filter($reduced_data, fn ($value) => !is_null($value));
        }

        return $reduced_data;
    }

    private static function _dfs(array $path, $data)
    {
        if (count($path) === 0) {
            return $data;
        }

        $newPath = array_slice($path, 1);

        if ($path[0] === '*') {
            if (gettype($data) !== 'array') {
                return null;
            }

            $newData = array_map(fn($item) => PathReducer::_dfs($newPath, $item), $data);
            if (in_array('*', $newPath)) {
                $newData = array_merge(...$newData);
            }
            return $newData;
        } else {
            if (!array_key_exists($path[0], $data)) {
                return null;
            }

            return PathReducer::_dfs($newPath, $data[$path[0]]);
        }
    }
}
