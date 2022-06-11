<?php


namespace alexKish\redirectManager;


interface RedirectRuleInterface
{
    public function compareAddresses(string $pathUrl): bool;
}