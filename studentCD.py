#!/usr/bin/env python
def largest(lst):
	largest = -1
	for num in lst:
		if num > largest:
			largest = num
	return largest

print(largest([5,6,2,7,1,4,2]))

print(largest([2,3,45,52,4,1]))

print(largest([1,2,3,4,5,6,7,8]))

print(largest([12,24,144,6,36]))

print(largest([8,3,6,1,13,13]))
