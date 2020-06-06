#Simple JSON API
Простое JSON-Pure API для простых задач, таких как VK MiniApps.
##Использование
GET или POST (опционально) запросы должны посылаться на api.php. Данные будут возвращены в виде JSON строки.
Структура ответа:
```json
{
  "status":"success",
  "response":{
    "message":"Successful Default API Method Call"
   }
}
```
Обязательным параметром является method, значением которого является имя вызываемого метода. При его отсутствии будет возвращена ошибка **103&nbsp;Неверный&nbsp;параметр&nbsp;**(Смотри список ниже).

При успешном выполнении запроса, **status** будет иметь значение **success**, в **response** будет содержаться тело ответа.
В противном случае, значением будет error, и в поле response будет содержаться тело ошибки. Типы и значения ошибок описаны ниже.


##Поддерживается
* Проверка подписи VK MiniApps
* Проверка типов входных параметров
* Защита от MySQL иньекций

##Требования:
* PHP 7.3
    * MySQLi

##Конфигурация
Базовые настройки описаны в config.php. 
```text
SIGN_VERIFICATION_REQUIRED - проверка подпписи данных.
```
 По умолчанию используется алгоритм VKMiniApps, можно выбрать собственный.

##Типы входных данных:
* integer
* string
* double
* Json
* DateTime
* Email
* HumanName 

Первые три типа соответствуют таковым в PHP, остальные: 
* Json - данные должны представлять собой валидную Json строку
* DateTime - данные должны предавлять собой валидную строку DateTime из PHP
* Email - данные должны представлять собой валидный Email адрес (для проверки используется стандартная функция filter_var)
* HumanName - данные должны представлять собой имя человека, допустимы русские (включая "ё") и латинские буквы обоих регистров.

 
##Создание методов
Каждый метод API обьявляется как класс PHP в папке **methods**. При этом, он должен реализовывать интерфейс **IMethod**, иначе не будет зарегистирован в списке методов и будет недоступен для вызова. 
```php
interface IMethod{
    public function __construct(array $inputData);
    public function Execute(): IReturnable;
}
```

Желательно также наследование от класса Method, в котором описаны методы ввода и вывода данных. Класс метода обязан содержать публичную константу CallableName, строка в которой будет являться названием метода при его вызове.
```php
public const CallableName = 'default';
```
#####Входные параметры
######Проверка входных параметров
По умолчанию, для метода включена проверка входных параметров. Для его отключения необходимо добавить публичную константу **RequireVerification** со значением **false**.
```php
public const RequireVerification = false;
```
При ее отсутствии, а так же значении **true** или **null**, проверка будет включена. 
######Описание входных параметров
Для описания входных параметров необходимо публичное свойство **$ParamsList**.
```php
public static $ParamsList = array(
       "name"=>"string",
       "id"=>"integer"
    );
```
В ассоциативном массиве нужно прописать параметры как ключи, и типы как значения.
####Описание метода
По интерфейсу IMethod, класс метода API должен иметь публичный конструктор и метод **Execute**.
##### Method::__construct
Данный конструктор уже реализован в абстрактном классе Method, поэтому нет необходимости в его повторной реализации. 
```php
    protected $data;
    public final function __construct(array $data){
        $this->data = $data;
    }
```
Конструктор принимает ассоциативный массив входных параметров в виде пары ключ-значение.
В последующем они доступны из переменной **$data**.
##### Method::Execute
Представляет из себя сердце метода API, именно он вызывается из **api.php**.
Возвращаемым значением должен быть обьект, реализующий интерфейс **IReturnable**.
####Создание ответа на запрос
Для возвращения ответа достаточно вернуть из **Execute** обьект класса **TheError** или **TheSuccess**

######IReturnable::TheSuccess
Представляет из себя успешное выполнение действия. В конструкторе принимает параметры **data** и необязательный **extra**.  **Data**&nbsp;представляет из себя возвращаемые данные. При null, в качестве ответа послужит значение **$extra**. 

######IReturnable::TheError
Представляет из себя ошибку, в конструкторе принимает **errorType** в качестве типа ошибки (смотри список), а также **extra** - дополнительное сообщение для вывода.
В качестве типа ошибки допустимо использование как буквенного, так и числового кода.

####База данных
В глобальном пространстве имен присутствует переменная $db, представляющая из себя открытое MySQL подключение. Используется библиотека **[Database](https://github.com/Vasiliy-Makogon/Database)** от **Vasiliy Makogon**.
Данные для подключения прописаны в **config.php**

##Стандартные типы ошибок
```text
Код ошибки (Буквенный код) - описание

1XX - Ошибки API
100 (undefined_error) - Неизвестная ошибка
101 (access_denied) - Доступ запрещен. Выдается при неправильной подписи входных данных или ее отсутствии.
102 (method_call_error) - Ошибка вызова метода. Вызвается при внутренней ошибке API.
103 (wrong_method) - Неверный метод. Название метода не передано в качестве параметра, или данный метод не существует.
104 (params_not_declared) - Параметры не определены. При включенной проверке типов параметров, класс метода не содержит $ParamsList, или он объявлен неверно.
105 (wrong_method_parameter) - Неверный тип входного параметра. Тип параметра не соответствует заявленному в $ParamsList. Дополнительно будет выведено подробное описание параметра. 


```



