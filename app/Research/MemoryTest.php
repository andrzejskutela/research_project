<?php

namespace App\Research;

class MemoryTest {
	const SET_MEN = 1;
	const SET_WOMEN = 2;
	const SET_NATURE = 3;

	protected array $order = [];

	public function __construct(?array $order = null) {
		if (!$order || count($order) !== 3) {
			$order = [self::SET_MEN, self::SET_WOMEN, self::SET_NATURE];
			shuffle($order);

		}

		$this->order = $order;
	}

	public function getTestImages() {
		$ret = [self::SET_MEN => [], self::SET_WOMEN => [], self::SET_NATURE => []];
		$iterator = [self::SET_MEN => 'men', self::SET_WOMEN => 'women', self::SET_NATURE => 'nature'];
		
		foreach ($iterator as $set => $folder) {
			$imageOrder = $this->getPseudoRandomSortedImageIds($set);
			foreach ($imageOrder as $i) {
				$ret[$set][] = '/public/images/' . $folder . '/' . str_pad($i, 2, '0', STR_PAD_LEFT) . '.jpg';
			}
		}

		return $ret;
	}

	public function getOrder() {
		return $this->order;
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
