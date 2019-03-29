# Refactoring project - Checkers

This is a fork of the original project, originally developed by [ryed8118](https://github.com/ryed8118). The intent is refactor the code and apply some software design patterns.

## Patterns Chosen
To this project, I chose to apply the three following patterns:

- **Adapter**: the adapter pattern is a software design pattern that allows the interface of an existing class to be used from another interface. It is often used to make existing classes work with others without modifying their source code [1].
- **Decorator**: the decorator pattern is a design pattern that allows behavior to be added to an individual object, dynamically, without affecting the behavior of other objects from the same class. The decorator pattern is often useful for adhering to the Single Responsibility Principle, as it allows functionality to be divided between classes with unique areas of concern [2].
- **Singleton**: the singleton pattern is a software design pattern that restricts the instantiation of a class to one "single" instance. This is useful when exactly one object is needed to coordinate actions across the system. The term comes from the mathematical concept of a singleton [3].

The last two patterns were applied in this repository, and the first was applied in [Tic Tac Toe](https://github.com/kevinwsbr/tictactoe) repository.

## How to build

### Environment setup
The project in this repository is a PHP application. To execute, you need to have an PHP interpreter available in your machine. The installation guide of PHP can be found [here](https://www.php.net/manual/en/install.php).
### Original project
To execute the original version (with bad smells), navigate to `smells` folder and start the PHP bult-in server:
```
php -S localhost:8000
```

Then, open that address in your browser.

### Modified project
The process to execute the modified version is the same of the original version, but you have to navigate to `clear` folder to access the new code. After that, you can start the server:
```
php -S localhost:8000
```

Please ensure that your cache is empty by restarting your browser or opening a private tab to avoid conflicts with the old version.

## Affected classes

The following old classes was affected:

- **Board**: the content of several methods was changed: large amount of duplicated code, unnecessary conditionals and absurdly large methods were reduced in smaller and simpler methods.
- **Square**: the file `square.php` was empty. So, the content of the `Square` class (originally located in `board.php`) was moved to it.

The following classes were created:

- **Game**: the `Game` class was developed to implement the `Singleton` pattern. All the game logic that was written in the `index.php` file was moved to this class. 
- **BoardPrintDecorator**: this class offers the implementation of the board print method (originally in `Board` class) - invoked in `Game::printBoard()` - using the Decorator pattern.

And finally, but no less important, the unnecessary comments in all files was removed and the page styles was moved (and updated) to `css/styles.css` stylesheet.

## Affected functionalities

- Game start
- Pieces movement
- Game style

## References

[1] [Adapter pattern](https://en.wikipedia.org/wiki/Adapter_pattern). originally in Wikipedia.

[2] [Decorator pattern](https://en.wikipedia.org/wiki/Decorator_pattern). originally in Wikipedia.

[3] [Singleton pattern](https://en.wikipedia.org/wiki/Singleton_pattern). originally in Wikipedia.