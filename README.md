## Introduction

[This package](https://github.com/maingocthanhtan96/larajs-i18n) allows converting language files from `.php` to `.json` to support frontend.

## Quick start

**Install**

```bash
composer require --dev larajs/i18n:dev-main
```

**Generate**

```php
php artisan larajs:i18n
```

**Publish config**

```php
php artisan vendor:publish --tag=larajs-i18n
```

**Frontend**

```ts
import {createI18n} from "vue-i18n";
import LaraJSI18n from "./i18n.generated.json";

const i18n = createI18n({
  messages: LaraJSI18n,
});

export default i18n;
```
