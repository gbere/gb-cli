TODO LIST
=========

## Core

- Load commands from a YAML file. [See huttopia/console-bundle](https://github.com/huttopia/console-bundle)
```yaml
# Load all commands
commands: ~
```
```yaml
# Only loads the command say:hello
commands:
    say:
        - hello
```
- Command wizard

### Maybe

- Enable and disable commands from a command
- Enable and disable debug mode from a command
- Run tests from a command
- Watch commands creates a cron task

## Commands

- net:info (ip local and public, ping ms)
- net:stat (sudo netstat -antpuew or similar)
- net:wizard (list and choose one)