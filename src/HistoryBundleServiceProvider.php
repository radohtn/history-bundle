<?php

namespace Htn\HistoryBundle;

use Htn\HistoryBundle\Command\CommandInterface;
use Htn\HistoryBundle\Command\CommandDispatcher;
use ReflectionClass;

class HistoryBundleServiceProvider
{
    /**
     * Enregistre toutes les commandes dans le dispatcher
     *
     * @param CommandDispatcher $dispatcher
     * @param string $commandDir
     */
    public static function registerCommands(CommandDispatcher $dispatcher, string $commandDir): void
    {
        foreach (glob($commandDir . '/*Command.php') as $file) {
            $className = self::getClassFromFile($file);

            if (!class_exists($className)) {
                continue;
            }

            $reflection = new ReflectionClass($className);

            // On ignore les commandes qui ont un constructeur obligatoire (ex: ListCommand)
            if ($reflection->implementsInterface(CommandInterface::class) &&
                $reflection->getConstructor()?->getNumberOfRequiredParameters() === 0) {

                // Nom de la commande = nom de la classe sans "Command", en minuscules
                $shortName = strtolower(str_replace('Command', '', $reflection->getShortName()));
                $dispatcher->register($shortName, new $className());
            }
        }
    }

    private static function getClassFromFile(string $file): string
    {
        $content = file_get_contents($file);

        preg_match('/namespace\s+([^;]+);/', $content, $namespaceMatch);
        preg_match('/class\s+(\w+)/', $content, $classMatch);

        $namespace = $namespaceMatch[1] ?? '';
        $class = $classMatch[1] ?? '';

        return $namespace && $class ? $namespace . '\\' . $class : '';
    }
}
