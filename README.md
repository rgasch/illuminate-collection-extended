
rgasch/illuminate-collection-extended is a small extension to Laravel's Collection class 
that provides some extra functionality to the Collection class.

## Installation

The preferred method of installation is via Composer. Run the following
command to install the package and add it as a requirement to your project's
`composer.json`:

```bash
composer require rgasch/illuminate-collection-extended
```

## Features

The main feature of this class is that it implements the __get() and __set() 
methods on Collections. This means that you can get and set Collection elements 
using the '->' syntax. For example: 

```
    $collection = new Rgasch\Collection(['a'=>0, 'b'=>1]);
    $a = $collection->a;
    print "a = $a\n";
```

The above code will retrieve the 'a' element of the Collection array and thus print "0".

It should be noted that retrieving elements via the '->' operator performs a test to 
verify that the element you are trying to retrieve actually exists; when trying to 
retrieve a non-existing element, an *InvalidArgumentException* will be thrown. The
rationale for this behavior is that this will flag typos and other stupid mistakes 
when trying to access Collection elements. 

Similarly, you can set elements using the "->" operator. For example: 

```
    $collection = new Rgasch\Collection(['a'=>0, 'b'=>1]);
    $collection->a = -1;
    $collection->c = 2;
```

The above code will result in a collection containing *[ 'a'=>-1, 'b'=>1, 'c'=>2 ]*

This class also provides a *create* method which can be used to create a collection with 
from the provided input. This method also optionally accepts a second *boolean* parameter 
*recursive* which specifies whether nested arrays/objects should be converted to nested 
Collections. See *tests/CollectionTest.php* for more details on this.

