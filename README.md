## 设计模式

### 创建型设计模式
---

#### [工厂方法模式](docs/factory.md)
工厂方法模式依据不同的请求创建不同的产品，这个产品与它的类之间不存在绑定。

#### [单例模式](docs/singleton.md)
为解决多个实例占用资源或者共用实例的问题，使用单例模式取得某个类的唯一实例。常见运用场景像数据库类、配置类。

#### [策略模式]()
将一组特定的行为和算法封装成类,以适应某些特定的上下文环境,这种模式就叫做策略模式。

使用策略模式可实现Ioc, 依赖倒置, 控制反转。

面相对象开发的关键是解耦。


### 数据对象映射模式
数据对象映射模式,是将对象和数据存储映射起来,对一个对象的操作会映射为对数据库的操作.

### 观察者模式
当一个对象状态发生改变时,依赖它的对象会全部收到通知,并自动更新.

### 原型模式
新生成原型对象并执行初始化方法后,用clone代替new创建对象,以此减少对象初始化的开销.


---

#### 参考

0.[Learning PHP设计模式](https://book.douban.com/subject/25952240/)

1.[大话设计模式](http://www.imooc.com/learn/236)

2.[PHP设计模式-胖胖的空间](http://www.phppan.com/php-design-pattern/)

3.[PHP The Right Way](http://laravel-china.github.io/php-the-right-way/pages/Design-Patterns.html)

4.[DesignPatternsPHP](http://designpatternsphp.readthedocs.org/en/latest/)