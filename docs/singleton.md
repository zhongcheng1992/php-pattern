### 单例模式

#### 用途
---
单例模式保证一个类仅有一个实例，并且提供一个访问它的全局访问点

单例模式有三个特点：

- 一个类仅有一个实例
- 必须自行创建实例
- biubiu向整个系统提供实例访问

#### 运用场景
---
单例模式保证我们在整个请求的生命周期内仅有唯一的实例。当我们有一个全局的对象（如配置类）或一个共享的资源（如事件队列、数据库链接）时适用。

大多数情况下，依赖注入可以（并且应该）代替单例类，使用依赖注入意味着我们不会在设计应用时引入不必要的耦合，因为对象使用共享的或全局的资源，不再耦合具体的类。

#### 代码示例
---

- 构造函数 `__construct()` 被声明为 protected 是为了防止用 new 操作符在这个类之外创建新的实例。
- 魔术方法 `__clone()` 被声明为 private 是为了防止用 clone 操作符克隆出新的实例.
- 魔术方法 `__wakeup()` 被声明为 private 是为了防止通过全局函数 unserialize() 反序列化这个类的实例。
- 新的实例是用过静态方法 `getInstance()` 使用后期静态绑定生成的。这允许我们对 Singleton 类进行继承，并且在取得 SingletonChild 的单例时不会出现问题。

```php
class Singleton
{
    protected static $_instance = null;

    protected function __construct() {}

    public static function getInstance()
    {
        if(self::$_instance == null) {
            self::$_instance = new self;
        }
        return self::$_instance;
    }

    private function __clone() {}

    private function __wakeup() {}
}
```

