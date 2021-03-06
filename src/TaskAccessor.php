<?php
namespace Robo;

trait TaskAccessor
{
    /**
     * Commands that use TaskAccessor must provide 'getContainer()'.
     */
    public abstract function getContainer();

    /**
     * Convenience function. Use:
     *
     * $this->task('Foo', $a, $b);
     *
     * instead of:
     *
     * $this->getContainer()->get('taskFoo', [$a, $b]);
     *
     * Note that most tasks will define another convenience
     * function, $this->taskFoo($a, $b), declared in a
     * 'loadTasks' trait in the task's namespace.  These
     * 'loadTasks' convenience functions typically will call
     * $this->task() to ensure that task objects are fetched
     * from the container, so that their dependencies may be
     * automatically resolved.
     */
    protected function task()
    {
        $args = func_get_args();
        $name = array_shift($args);
        // We'll allow callers to include the literal 'task'
        // or not, as they wish; however, the container object
        // that we fetch must always begin with 'task'
        if (!preg_match('#^task#', $name)) {
            $name = "task$name";
        }
        return $this->getContainer()->get($name, $args);
    }
}
