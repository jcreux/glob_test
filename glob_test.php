#!/usr/bin/php
<?php

/* ===== Code ===== */

function	error_checker($array) {
	if (!is_array($array)) {
		return (false);
	}
	foreach ($array as $elem) {
		if (!is_array($elem) || count($elem) !== 2 || !is_int($elem[0]) || !is_int($elem[1]) || $elem[0] > $elem[1]) {
			return (false);
		}
	}

	return (true);
}

function	merge_checker($elem1, $elem2) {
	if (($elem1[0] >= $elem2[0] && $elem1[0] <= $elem2[1]) || ($elem2[0] >= $elem1[0] && $elem2[0] <= $elem1[1])) {
		return (true);
	}

	return (false);
}

function	merge_elems($array, $x, $y) {
	$array[$x] = [min($array[$x][0], $array[$y][0]), max($array[$x][1], $array[$y][1])];
	unset($array[$y]);

	return (array_values($array));
}

function	sort_array($array) {
	$new_array = [];

	for ($x = 0; count($array) > 0; $x++) {
		$min_elem = $array[0];
		$min_index = 0;
		for ($y = 0; $y < count($array); $y++) {
			if ($min_elem[0] > $array[$y][1]) {
				$min_elem = $array[$y];
				$min_index = $y;
			}
		}
		$new_array[$x] = $min_elem;
		unset($array[$min_index]);
		$array = array_values($array);
		$y = 0;
	}

	return ($new_array); 
}

function	foo($array) {
	$x = 0;
	$incr_x = true;

	if (!error_checker($array)) {
		print("Wrong argument.\n");
		return (null);
	}

	while ($x < count($array)) {
		for ($y = 0; $y < count($array); $y++) {
			if ($y !== $x && merge_checker($array[$x], $array[$y])) {
				$array = merge_elems($array, $x, $y);
				$incr_x = false;
				break;
			}
		}
		if ($incr_x) {
			$x++;
		} else {
			$x = 0;
			$incr_x = true;
		}
		$y = 0;
	}

	return (sort_array($array));
}


/* ===== Tests ===== */

print_r(foo([[0, 3], [6, 10]]));
// Expected output : [[0, 3], [6, 10]]

print_r(foo([[0, 5], [3, 10]]));
// Expected output : [[0, 10]]

print_r(foo([[0, 5], [2, 4]]));
// Expected output : [[0, 5]]

print_r(foo([[7, 8], [3, 6], [2, 4]]));
// Expected output : [[2, 6], [7, 8]]

print_r(foo([[3, 6], [3, 4], [15, 20], [16, 17], [1, 4], [6, 10], [3, 6]]));
// Expected output : [[1, 10], [15, 20]]

print_r(foo([[2, 5], [15, 17], [3, 10]]));
// Expected output : [[2, 10], [15, 17]]

print_r(foo([[15, 17], [2, 5], [3, 10]]));
// Expected output : [[2, 10], [15, 17]]

print_r(foo([[1, 2], [3, 3]]));
// Expected output : [[1, 2], [3, 3]]

print_r(foo([[1, 5], [3, 3]]));
// Expected output : [[1, 5]]

print_r(foo([[-2, 3], [0, 1]]));
// Expected output : [[-2, 3]]

print_r(foo([]));
// Expected output : []

print_r(foo('a'));
// Expected output : Wrong argument.

print_r(foo(true));
// Expected output : Wrong argument.

print_r(foo(null));
// Expected output : Wrong argument.

print_r(foo(['a', [3, 4], true, null, 40]));
// Expected output : Wrong argument.

print_r(foo([[2, 3, 4], [0, 1, 2]]));
// Expected output : Wrong argument.

print_r(foo([[2, 3, 4], [0, 'a', 0, 0]]));
// Expected output : Wrong argument.

print_r(foo([[2, 3], [0, '1']]));
// Expected output : Wrong argument.

print_r(foo([[3, 6], [3, 4], [15, 20], [16, 17], [1, 4], ['2', 3]]));
// Expected output : Wrong argument.

print_r(foo([[[3, 1], 17], [2, 5], [3, 10]]));
// Expected output : Wrong argument.

print_r(foo([[13, 6], [3, 4], [15, 20], [16, 17], [1, 4]]));
// Expected output : Wrong argument.


/* ===== Questions ===== /

Question 1)
Cette fonction prend en argument un tableau de "segments" (tableau de 2 entiers dont le premier est inférieur ou égal au second).
Si cet argument est un tableau vide, elle renvoie un tableau vide. Hormis ce cas particulier, elle affiche une erreur et renvoie null si l'argument fourni n'est pas un tableau de segments.
Sinon elle fusionne récursivement les segments qui se chevauchent entre-eux, afin de renvoyer un tableau de segments strictement distincts triés par ordre croissant.

Question 2)
Cf. ci-dessus.

Question 3)
Environ 1 heure.

*/


?>
