<?php

namespace App\Aoc\Day11;

class Actions
{
    private Action $onTrueAction;
    private Action $onFalseAction;

    private function __construct(Action ...$actions)
    {
        foreach ($actions as $action) {
            if ($action->condition()) {
                $this->onTrueAction = $action;
            } else {
                $this->onFalseAction = $action;
            }
        }
    }

    public static function fromNotes(string ...$notes): self
    {
        $actions = array_map(function (string $note) {
            return Action::fromNote($note);
        }, $notes);

        return new self(...$actions);
    }

    public function onTrueSpec(): string
    {
        return $this->onTrueAction->spec();
    }

    public function onFalseSpec(): string
    {
        return $this->onFalseAction->spec();
    }

    public function getAction(bool $result): Action
    {
        if ($result) {
            return $this->onTrueAction;
        }

        return $this->onFalseAction;
    }
}
