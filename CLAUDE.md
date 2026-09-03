# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## 项目概述

这是一个 Meilisearch PHP 客户端库，用于与 Meilisearch 搜索引擎进行集成。当前处于开发测试阶段。

### 依赖要求
- PHP >= 7.0
- ext-curl, ext-json
- iboxs/redis（用于缓存 API Key）
- iboxs/basic（提供 HTTP 请求工具）

### 命名空间
- 主命名空间: `iboxs\meilisearch`
- PSR-4 自动加载: `iboxs\meilisearch\` -> `src/`

## 架构设计

### 核心入口类
`Meilisearch` (src/Meilisearch.php) 是整个库的入口点：
- 通过 `__get()` 魔术方法动态加载 API 模块（如 `$meilisearch->index`、`$meilisearch->documents`）
- 使用 `key` trait 管理 API Key 获取和缓存
- 提供 `getInstance()` 静态方法从配置创建实例

### API 模块结构
所有 API 模块位于 `src/api/` 目录，继承自 `BaseApi`：
- `index.php`: 索引管理（创建、查询等）
- `documents.php`: 文档管理（添加、替换、删除等）

每个 API 模块通过 `BaseApi` 获得 `$masterKey`、`$host`、`$apiKey` 属性。

### API Key 管理
`key` trait (src/lib/key.php) 负责：
- 从 Meilisearch 获取 Default Admin API Key 和 Default Search API Key
- 使用 Redis 缓存 API Key（24小时过期）
- 缓存键格式: `meilisearch:api_key:{md5(host+masterKey)}`

### HTTP 请求
所有 HTTP 请求通过 `iboxs\basic\Basic::Http()` 工具类发起：
- 使用 `setHeader()` 设置 Authorization Bearer token
- 使用 `postJson()` 发送 JSON 数据
- 使用 `get()` 获取数据

## 开发规范

### 添加新的 API 模块
1. 在 `src/api/` 创建新文件，类名与文件名一致
2. 继承 `iboxs\meilisearch\lib\BaseApi`
3. 在构造函数中自动获得 `$masterKey`、`$host`、`$apiKey`
4. 使用 `$this->apiKey['adminKey']` 或 `$this->apiKey['searchKey']` 进行 API 调用
5. 在 `Meilisearch` 类的 `@property` 注释中添加类型提示

### API 调用模式
```php
$url = $this->host . '/indexes/' . $indexID . '/documents';
$ret = Basic::Http($url)->setHeader([
    'Authorization: Bearer ' . $this->apiKey['adminKey']
])->postJson($documents);
```

### 配置获取
代码中使用 `config('meilisearch.masterKey')` 和 `config('meilisearch.host')` 获取配置，需确保运行环境提供 `config()` 函数。

## 辅助函数

`src/helper.php` 提供了全局辅助函数：
- `dd()`: 调试输出并终止
- `wechatExpireTime()`: 微信过期时间格式化（似乎误放此处）
- `Nullify()`: 移除数组中的 null 值
