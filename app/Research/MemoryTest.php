<?php

namespace App\Research;

use Illuminate\Support\Arr;

class MemoryTest {
	const SET_MEN = 1;
	const SET_WOMEN = 2;
	const SET_NATURE = 3;
	const SET_FLOWERS = 4;

	protected array $order = [];

	public static function getAllPossibleSets() : array {
		$reflection = new \ReflectionClass(__CLASS__);
        return Arr::where($reflection->getConstants(), function (int $value, string $key) {
        	return strpos($key, 'SET_') === 0;
        });
	}

	public function __construct(?array $order = null) {
		if (!$order || count($order) !== 3) {
			$order = [ self::SET_NATURE, self::SET_WOMEN, self::SET_MEN, ];
		}

		$this->order = $order;
	}

	public function getTestImages() : array {
		$ret = [self::SET_MEN => [], self::SET_WOMEN => [], self::SET_NATURE => []];
		$iterator = [self::SET_MEN => 'men', self::SET_WOMEN => 'women', self::SET_NATURE => 'nature'];
		
		foreach ($iterator as $set => $folder) {
			$imageOrder = $this->getPseudoRandomSortedImageIds($set);
			foreach ($imageOrder as $i) {
				$ret[$set][] = asset('/images/' . $folder . '/' . str_pad($i, 2, '0', STR_PAD_LEFT) . '.jpg');
			}
		}

		return $ret;
	}

	public function getOrder() : array {
		return $this->order;
	}

	public function getImageDisplayRandomnessSettings() : array {
		srand(34234);
		$ret = [];

		for ($i = 0; $i < 40; $i++) {
			$tmp = [];
			for ($j = 0; $j <= $i; $j++) {
				$tmp[] = rand(1,99);
			}

			$ret[] = implode(',', $tmp);
		}

		$ret = [
			0 => '1',
			1 => '1,2',
			2 => '1,3,2',
			3 => '1,2,3,4',
			4 => '2,3,5,4,1',
			5 => '5,4,2,6,1,3',
			6 => '6,2,3,1,5,4,7',
			7 => '8,1,7,6,4,5,2,3',
		] + $ret;

		return $ret;
	}

	protected function getPseudoRandomSortedImageIds(int $seed) : array {
		srand(299706 + $seed);
		$ret = [];

		for ($i = 1; $i < 40; $i++) {
			$ret[$i] = rand();
		}

		asort($ret);
		return array_keys($ret);
	}
}
