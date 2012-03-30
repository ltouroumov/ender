Ender Framework
===============
Ender framework aims to be a multi purpose PHP framework that can be included inside projects to prevent code redundancy.
The system aims to be as modular as possible.

The parts
---------
The framework is broken down into multiple parts:

 * **base/core** contains all the base classes for the framework such as the `array` wrapper `ArrayCollection`.
 * **base/cli** contains cli support such as a basic arguments parser, modular commands and automatic help messages.
 * **mvc/tiny** micro mvc framework in the line of `Silex`.
 * **mvc/medum** intermediate framework for the people in need for more than `tiny` but smaller than `full`.
 * **mvc/full** full fleged MVC framework in the lines of `Symfony` without the french accent.
 * **orm/tiny** micro orm that doesn't offer a lot of features but is great for small projects. Use it with `mvc/tiny` for quick small database aware applications.
 * **orm/full** full fledged ORM layer in the lines of `Doctrine`

The manual
----------
Each class should be documented using doxygen syntax. And a summary/usage manual in the `README.md` of each module.