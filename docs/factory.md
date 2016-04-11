### 工厂方法模式（Factory Method）

#### 用途


---
定义一个创建对象的接口，根据使用场景创建不同的类的实例。工厂方法模式使用一个类的实例化延迟到其子类。

#### 运用场景

---
如果实例化对象的子类可能发生变化，就需要用到工厂方法模式。
这种方式创建对象有两个好处:
首先如果需要修改Cache类或添加新Cache类，只需要在工厂方法中修改，而不用在每个用到缓存的地方修改。
其次如果实例化对象的步骤很复杂，也仅需要在工厂方法中实现即可。

#### 工厂方法模式结构图

---

#### 代码示例

```php
class CacheFactory
{
    public static function setCache($driver)
    {
        switch ($driver) {
            case 'file':
                $cache = new fileCache();
                break;
            case 'redis':
                $cache = new redisCache();
                break;
            default:
                $cache = new Cache();
        }
        return $cache;
    }
}

class Cache {}

class fileCache extends Cache {}

class redisCache extends Cache {}

$cache = CacheFactory::setCache('redis');
```