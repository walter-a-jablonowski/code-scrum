# Code SCRUM

**Your code is your backlog**

Task are saved in code, you see the context, and you can generate a backlog. 2 for 1 with a low code tool. It has more structure than in an IDE, where everything is grouped just by file.

- Copy under some /tools folder in project
- `composer install`
- Edit config


### Sample

Place tasks.yml files anywhere within your /src. You could also make sub dir for some resources.

```yaml
- tag:  Backlog|RELEASE  # Backlog is fix, RELEASE = "0.1" ...
  prio: MUST|SHOULD|CAN
  name: My main task
- 
  ...
```

Place tasks in your code where u like

```php
some code  // TASK: [B/My main task] CAN do this and that...  # where B is Backlog
```

- 'do this and that' will appear under main task 'my main task'
- This `[...]` is called **TAG** (optional)
- Tasks without a TAG appear in `Backlog/Misc`
- You can also use `B/more/hierarchie/...`
- **Priorities** (optional) are MUST=1 SHOULD=2 CAN=3

You could also use just full text search in vsc `// TASK:` for all, `// TASK: [B/...` for something specific.


### Code tags

Just use `// TAG: UNIQUE-NAME` in multiple places, then full text search.


### Plans

maybe...

- [ ] Change order of CAN and TAG as soon as we known how we can use MUST|SHOULD|CAN in VSC
  - => search for `// TASK: CAN` or `// TASK: (MUST|SHOULD|CAN) [B/...`
- [x] Gimmik: Make main group folding
- [ ] Style table
- [x] Add sorting
- [ ] Link resources per task like file.md oder folder, viewer adds a link


## License

Copyright (C) Walter A. Jablonowski 2011-2021, MIT [License](LICENSE)

Licenses of third party software used see [credits](credits.md)


[Privacy](https://walter-a-jablonowski.github.io/privacy.html) | [Legal](https://walter-a-jablonowski.github.io/imprint.html)
