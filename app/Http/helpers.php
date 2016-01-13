<?php
/**
 * Convert any variable to a boolean value. A true boolean value consists of one of the following:
 * 1, true, "yes", "on", "1", "y", "true", "t"
 *
 * @param mixed $var The variable to check
 *
 * @return boolean
 */
function toBool($var) {
	if (true === $var || 1 === $var) {
		return true;
	}
	switch (strtolower($var)) {
		case "yes":
		case "on":
		case "1":
		case "y":
		case "true":
		case "t":
			return true;
		default:
			return false;
	}
}