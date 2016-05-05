框架名称：LaneWeChat

框架简介：这是一个为快速开发微信应用而生的PHP框架。将微信的开发者功能根据文档进行了封装。为了快速开发的目的，开发者完全不需要要知道具体是如何实现的，只需要简单的调用方法即可

开发语言：PHP

版本要求：原则PHP5.3以上

版本规避：若版本低于PHP5.3，则删除本框架所有页面开头“namespace”的行、删除本框架中所有的“use LaneWeChat”开头的行，删除“LaneWeChat\Core”，修改Autoloader::NAMESPACE_PREFIX=''，修改curl.lib.php的\Exception为Exception即可。

命名空间：本框架的命名空间均为LaneWeChat开头。

开源协议：Do What The Fuck You Want To Public License

开发者博客：http://www.lanecn.com

文档地址：<a href="http://lanewechat.lanecn.com/">http://lanewechat.lanecn.com/</a>

更新日志：

    2016-05-05 1.5.4

        1、接收数据方式由HTTP_RAW_POST_DATA替换为php://input. HTTP_RAW_POST_DATA在PHP5.6以后就不再推荐使用.

    2016-04-26 1.5.4

        1、新增生成个性化菜单方法Menu::setPersonalMenuJson($menuListJson)

        2、新增生成默认菜单方法Menu::setMenuJson($menuListJson)，与原生成默认菜单函数Menu::setMenu($menuList)，此函数参数是json字符串
        
        3、新增Environment类, isSae($appname,$accesskey)方法判断所在环境是否是SAE平台。

        4、外部类调用的入口，一定是getAccessToken()，所以进入此方法后调用Environment::isSae($appname,$accesskey)判断平台属性，若不是SAE，逻辑不变原用户不受影响，否则根据SAE环境执行不同的获取token的方法。

        5、新增AccessToken::_getSae()方法，在SAE平台上根据条件的不同,选择从memcache/文件/数据库中读取access_token.

        6、新增AccessToken::_getFromMemcache()方法，在SAE平台上从memcache中读取access_token。

        7、新增AccessToken::_getFromFile()方法，从文件中读取access_token。
            1) 在获取access_token的过程中需要调用私有方法_existsToken(),_expriseToken()
            2) 此方法在其他平台上的可写目录中可以正常执行,因为SAE平台不支持本地创建/写文件,可通过改写此方法在SAE的storage中创建/读/写文件,
            个人感觉任何缓存、中间临时交换数据的需求都是不适合使用Storage和KVDB存储的,所以没有添加相关的方法实现(有什么理解不对的请指出)。

        8、改写WechatRequest::eventQrsceneSubscribe方法，用户在扫描带参数二维码之后，可根据所带参数实现对用户自动分组的功能

    1、修复主动响应的BUG，感谢 晨露微凉<jokechat@qq.com> 反馈。

    2015-10-21 1.5.3

        1、文件上传根据PHP版本增加了CURLFile()类。自PHP5.5以后，废弃了“@文件名”的方式上传文件

    2015-06-29 1.5.2

        1、在主动发消息模块（responseinitiative.lib.php）pic_url 和 url赋值反了。

    2015-04-29 1.5.1

        1、新增获取微信服务器IP列表接口。如果需要安全性校验，可以每次判断请求的来源IP。

        2、新增接收消息类型：小视频

        3、新增 模板消息-设置行业 和 模板消息-获取模板ID

        4、高级群发接口-根据分组群发 新增参数is_to_all，使用is_to_all为true且成功群发，会使得此次群发进入历史消息列表。

        5、新增 高级群发接口-预览接口【订阅号与服务号认证后均可用】 和 高级群发接口-查询群发消息发送状态【订阅号与服务号认证后均可用】

        6、新增 客服帐号管理-获取所有客服账号列表/添加客服账号/修改客服账号/删除客服账号/设置客服头像

        7、新增 自动回复-获取自动回复 接口

    2014-12-04 1.4.2

        1、解决CURL的GET调用在php5.3以下时出现errno=60(CA证书无效)的BUG。（解决人：大志<229417598@qq.com>）

        2、文档、注释优化。（zhulin3141）

        3、实战演练 - 添加微信自定义菜单 文档场景描述错误

    2014-11-05：1.4版本

        兼容性：
            设置菜单Menu::setMenu($menuList)参数结构和返回值重写，不向下兼容。
        根目录下新增lanewechat.php：
            在项目用需要使用本SDK的地方，只需要include 'lanewechat/lanewechat.php'，然后可以直接ClassName::method()调用即可。

        安全性升级：
            因为SSL爆出高危漏洞，公众平台在2014.11.30起，将关闭SSLv2，SSLv3版本的支持。根据官方实例，LaneWeChat的CURL类中也将使用curl_setopt($curl, CURLOPT_SSLVERSION, 1)

        新增消息体签名加解密验证（EncodingAESKey），默认为空，为空时微信公众号平台会自动生成。也可以开发者自行手动指定。

        新增语音消息识别

        新增高级群发接口：
            1 上传图文消息素材
            2 根据分组进行群发，可发送图文消息，文本消息，图片消息，语音消息，视频消息。
            3 根据OpenID列表群发，，可发送图文消息，文本消息，图片消息，语音消息，视频消息。
            4 删除群发
            5 事件推送群发结果

        新增模板消息接口：
            1、主动推送给用户模板消息的接口
            2、被动接收微信服务器发送的关于主动推送模板消息的结果通知。

        用户管理接口：
            1、新增设置备注名。开发者可以通过该接口对指定用户设置备注名，该接口暂时开放给微信认证的服务号。

        网页授权接口：
            注意：此access_token与基础支持的access_token不同。
            1、新增刷新access_token。由于access_token拥有较短的有效期，当access_token超时后，可以使用refresh_token进行刷新，refresh_token拥有较长的有效期（7天、30天、60天、90天），当refresh_token失效的后，需要用户重新授权。
            2、新增scope为snsapi_userinfo的模式下（会在网页弹出一个授权框），拉取用户信息的接口。
            3、新增检验授权凭证（access_token）是否有效接口

        新增多客服功能：
            1、新增将消息转发到多客服接口：在接收到用户发送的消息时，调用ResponsePassive::forwardToCustomService($fromusername, $tousername)，微信服务器在收到这条消息时，会把这次发送的消息转到多客服系统。用户被客服接入以后，客服关闭会话以前，处于会话过程中，用户发送的消息均会被直接转发至客服系统。
            2、新增获取客服聊天记录接口：在需要时，开发者可以通过获取客服聊天记录接口，获取多客服的会话记录，包括客服和用户会话的所有消息记录和会话的创建、关闭等操作记录。利用此接口可以开发如“消息记录”、“工作监控”、“客服绩效考核”等功能。

        自定义菜单：
            警告：设置菜单Menu::setMenu($menuList)参数结构和返回值重写，自1.4版本起不向下兼容。
            注意：所有新增的菜单类型，仅支持微信iPhone5.4.1以上版本，和Android5.4以上版本的微信用户，旧版本微信用户点击后将没有回应，开发者也不能正常接收到事件推送。
            1、新增“scancode_push：扫码推事件”类型菜单
                用户点击按钮后，微信客户端将调起扫一扫工具，完成扫码操作后显示扫描结果（如果是URL，将进入URL），且会将扫码的结果传给开发者，开发者可以下发消息。
            2、新增“scancode_waitmsg：扫码推事件且弹出‘消息接收中’提示框”类型菜单
                用户点击按钮后，微信客户端将调起扫一扫工具，完成扫码操作后，将扫码的结果传给开发者，同时收起扫一扫工具，然后弹出“消息接收中”提示框，随后可能会收到开发者下发的消息。
            3、新增“pic_sysphoto：弹出系统拍照发图”类型菜单
                用户点击按钮后，微信客户端将调起系统相机，完成拍照操作后，会将拍摄的相片发送给开发者，并推送事件给开发者，同时收起系统相机，随后可能会收到开发者下发的消息。
            4、新增“pic_photo_or_album：弹出拍照或者相册发图”类型菜单
                用户点击按钮后，微信客户端将弹出选择器供用户选择“拍照”或者“从手机相册选择”。用户选择后即走其他两种流程。
            5、新增“pic_weixin：弹出微信相册发图器”类型菜单
                用户点击按钮后，微信客户端将调起微信相册，完成选择操作后，将选择的相片发送给开发者的服务器，并推送事件给开发者，同时收起相册，随后可能会收到开发者下发的消息。
            6、新增“location_select：弹出地理位置选择器”类型菜单
                用户点击按钮后，微信客户端将调起地理位置选择工具，完成选择操作后，将选择的地理位置发送给开发者的服务器，同时收起位置选择工具，随后可能会收到开发者下发的消息。
            7、新增了以上6种菜单类型、view（点击跳转链接）的菜单类型的被动响应的支持。默认讲点击菜单的事件推送数据发送文本消息返回给用户。开发者请自行修改。

        新增语义理解接口
            1、如输入“查一下明天从北京到上海的南航机票”，类型为“flight,hotel”，则返回机票信息。

        新增推广支持：
            1、新增获取二维码接口。二维码分临时二维码和永久二维码。第一步先获取ticket，第二部是拿ticket获取二维码图片。二维码可以保存为文件，也可以展示预览。
            2、新增长链接转短链接接口。

        新增实例示范：
            1、被动响应用户 - 发送图文消息
            2、群发图文消息
            3、推送模板消息
            4、添加自定义菜单
            5、页面展示二维码

        关于获取用户信息的新亮点 - unionId：
            获取用户信息是根据openId获取，同一个微信用户对于不同的公众号，是不同的openId。那问题就来了，如果你有多个公众号，想要共享一份用户数据，可是同一个用户在不同的公众号是不同的openId，我们无法判断是否是同一个用户，现在微信引入了UnionId的概念。
            如果开发者有在多个公众号，或在公众号、移动应用之间统一用户帐号的需求，需要前往微信开放平台（open.weixin.qq.com）绑定公众号后，才可利用UnionID机制来满足上述需求。
            在绑定了公众号后，我们根据openId获取用户信息的时候，会新增一个字段“unionid”，只要是同一个用户，在不同的公众号用不同的openId获取用户信息的时候unionid是相同的。
            此功能不需要新增/修改代码，只需要在微信开放平台绑定公众号就可以了。仍旧使用获取用户信息接口UserManage::getUserInfo($openId);

    2014-10-14：1.2.2版本。新增自动载入函数

    2014-08-17：1.2版本。新增自定义菜单功能、新增多媒体上传下载功能。

    2014-08-07：1.0版本

文档目录：

    1、常识普及。

    2、如何安装。

    3、初出茅庐。

    4、流程分析。

    5、牛刀小试。

    6、函数详解。

    7、实例示范。

常识普及：

一、微信公众账号分两种，一种是订阅号，一种是服务号。

    1、订阅号是被动响应用户消息功能，并且每天推送一条消息。

    2、服务号是300元/每年认证，被动响应用户消息，主动给用户发送消息，自定义菜单按钮，网页授权等功能，并且每月推送一条消息。

    3、订阅号适合消息类，新闻类应用，常常需要推送文章给用户的；服务号适合自助查询等。

    4、订阅号被认证后也享用自定义菜单等功能，仍旧是300元/每年

二、专业术语：

    1、OpenId：微信服务器并不会告诉公众号用户的微信ID，即使是你的关注者也不行，为了解决开发中唯一标识的问题，微信使用了OpenId，所谓的OpenId，就是用户和微信公众号之间的一种唯一关系。一个用户在一个公众号面前，享用唯一的OpenId，不会和别人重复。换言之，同一个用户在另一个公众号面前，是拥有另一个OpenId的。再直白些就是$openId = md5('用户微信ID+公众号ID')

    2、Access_Token：此项只有认证号的功能才会使用的到，Access_token是一个授权标识，即一个授权验证码，一个标识10分钟内有效，10分钟的有效期内公众号的多个关注者可以使用同一个Access_Token。在使用主动给指定用户发送消息、自定义菜单、用户管理和用户组管理等功能的时候，每次操作需要给微信服务器以参数的形式附带Access_token。

    3、Access_Token网页版：本Access_Token网页版授权时会使用到，和2中的Access_Toekn是不同的东西，不过使用我们的LaneWeChat微信快速开发框架是不需要了解这些的。Access_Token网页版是说在用户打开你的公众号提供的网页的时候，你的网页需要获取用户的OpenId、昵称、头像等信息的时候授权用的。同时，本Access_Token网页版有两种用法，一种是打开网页后弹出一个授权框，让用户点击是否授权，界面像主流的开放平台授权界面（比如QQ登陆某网站，支付宝账号登陆某网站等）；另一种是不需要弹出授权框仍旧可以获取用户信息，用法可以在实例中看到。

如何安装：

    1、本框架以代码包的插件形式放在项目的目录中即可。调用时只需要include 'lanewechat/lanewechat.php'即可。如：
            <?php
            include 'lanewechat/lanewechat.php';
            //获取自定义菜单列表
            $menuList = Menu::getMenu();

    2、配置项：打开根目录下的config.php，修改定义常量WECHAT_APPID，WECHAT_APPSECRET，WECHAT_URL。其中前两项可以在微信公众号官网的开发者页面中找到，而WECHAT_URL是你微信项目的URL，以http://开头

    3、本框架的外部访问唯一入口为根目录下的wechat.php，本框架的内部调用唯一入口为根目录下的lanewechat.php。两者的区别是wechat.php是通过http://www.abc.com/lanewechat/wechat.php访问，是留给微信平台调用的入口。而lanewechat.php是我们项目内部调用时需要include 'lanewechat/lanewechat.php';

    4、首次使用时，请打开根目录下的wechat.php，注释掉26行，并且打开注释第29行。

    5、在微信开发者-填写服务器配置页面，填写URL为http://www.lanecn.com/wechat.php，保证该URL可以通过80端口正常访问（微信服务器目前只支持80端口），并且将Token填写为config.php中的WECHAT_TOKEN常量的内容（可以修改）。

    6、微信服务器在第4步验证通过后，反向操作第4步，即注释掉第27行，打开注释第26行。至此，安装配置完成。

初出茅庐：

    1、给你的微信公众号发送一条文本消息，比如hello world或者其他什么的。这个时候你应该会收到一条“收到文本”的服务器反馈的被动响应的消息。

    2、这个时候你需要先为自己鼓掌。

流程分析：

    1、我们给微信服务器发送了一条“hello world”的文本消息。

    2、微信服务器收到我们的消息后，查找该公众账号所配置的服务器信息中的URL（如何安装部分 - 第5步）。

    3、微信服务器向第二步获取的URL发送请求，参数是微信服务器自己拼接过的XML格式。

    4、根目录下的wechat.php，引入了我们的配置文件和所需的类后，进入了类WeChat的方法run()。该类位于core/wechat.lib.php。微信的XML数据此时已经被解析为数组，变量名为$request。

    5、然后，我们进入了类WechatRequest的方法switchType()，根据不同的消息类型，给予不同的响应。比如用户发送文本消息和关注事件，给出的返回应该是不同的。当然，你要给出同样的提示也不能说是错的。

    6、在第5步中的方法中，是一个switch，根据消息类型（此时是文本类型，微信服务器给我的是text）选择了一个处理文本消息的方法，类WechatRequest中的方法text()。该方法的功能是发送文本消息，文本内容是“收到文本”。

    7、此时，我们return了一个数据返回给了上层调用，层层return，就到了我们根目录的下的唯一入口文件wechat.php，此时我们返回的数据被echo出来了。

    8、微信服务器拿到了输出的数据，微信服务器进行分析和处理，将文本发送给了用户的微信客户端。我们就在手机上看到了微信输出的“收到文本”。

    9、流程结束，这就是发送“hello world”，然后返回给用户“收到文本”。

牛刀小试：

    1、打开core/wechatrequest.php文件，讲方法text()中的变量修改为$content = '收到文本消息'.$request['content'];

    2、保存并且上传到你的服务器。

    3、在微信中打开你的公众号，输入文本消息“hello world”。见证奇迹的时刻到了。这个时候你的手机微信客户端中现实的是“收到文本消息hello world”。

函数详解：

    一、被动给用户发送消息。

        1、类简介：用户输入文本、图片、语音、音乐、视频等消息，以及关注、取消关注，上报地理位置等事件后，服务器被动给出应答。

        2、使用命名空间：use LaneWeChat\Core\ResponsePassive;

        3、参数：  $fromusername = "谁发给你的？（用户的openId）"  在变量$request['fromusername']中

                 $tousername = "你的公众号Id";                 在变量$require['tousername']中

                 $mediaId = "通过上传多媒体文件，得到的id。";

        4、发送文本
                ResponsePassive::text($fromusername, $tousername, '文本消息内容');

        5、发送图片
                ResponsePassive::image($fromusername, $tousername, $mediaId);

        6、发送语音
                ResponsePassive::voice($fromusername, $tousername, $mediaId);

        7、发送视频
                ResponsePassive::video($fromusername, $tousername, $mediaId, '视频标题', '视频描述');

        8、发送音乐
                ResponsePassive::music($fromusername, $tousername, '音乐标题', '音乐描述', '音乐链接', '高质量音乐链接，WIFI环境优先使用该链接播放音乐', '缩略图的媒体id，通过上传多媒体文件，得到的id');

        9、发送图文
            1）创建图文消息内容
                $tuwenList = array();
                $tuwenList[] = array('title'=>'标题1', 'description'=>'描述1', 'pic_url'=>'图片URL1', 'url'=>'点击跳转URL1');
                $tuwenList[] = array('title'=>'标题2', 'description'=>'描述2', 'pic_url'=>'图片URL2', 'url'=>'点击跳转URL2');
            2）构建图文消息格式
                $itemList = array();
                foreach($tuwenList as $tuwen){
                    $itemList[] = ResponsePassive::newsItem($tuwen['title'], $tuwen['description'], $tuwen['pic_url'], $tuwen['url']);
                }
            3）发送图文消息
                ResponsePassive::news($fromusername, $tousername, $itemList);

    二、AccessToken授权。

        1、类简介：除了被动相应用户之外，在主动给用户发送消息，用户组管理等高级操作，是需要AccessToken授权的，我们调用一个URL给微信服务器，微信服务器会返回给我们一个散列字符串，在高级操作的时候需要将此串以参数的形式发送。散列字符串10分钟内有效，过期需要重新获取，获取新的后之前的全部失效。

        2、使用命名空间：use LaneWeChat\Core\AccessToken;

        3、参数：无

        4、获取AccessToken
            AccessToken::getAccessToken(); 该调用会返回微信服务器散列后的AccessToken字符串。

        5、温馨提示

            如果暂且用不到此功能，请跳过。最后来看这里！

        6、功能补充
            有一个地方需要用户自行完善，根据介绍我们已经知道了，获取AccessToken只有10分钟的有效期，过期需要重新获取。因此，我们需要存储这个AccessToken。
            由于大家的存储方式各不相同，有Mysql的，有Redis的，有MongoDB的，还有Session的。所以这里我讲存储和读取给留空了。
            流程：AccessToken类，public方法只有一个，就是getAccessToken()。这个方法会调用一个私有方法_checkAccessToken()来检测AccessToken是否存在并且是否过期，如果不存在或过期，则调用私有方法_getAccessToken()
            完善步骤：
            1）、打开core/accesstoken.lib.php文件。
            2）、私有方法_getAccessToken()的倒数第二行（return是倒数第一行），在这个地方，请讲变量$accessTokenJson存储起来，变量$accessTokenJson是一个字符串。
            3）、私有方法_checkAccessToken()的第一行就是读取操作（有一行伪代码$accessToken = YourDatabase::get('access_token');），将刚才第二步的存储的东西给读出来，并且赋值给$accessToken。
            4）、在第二步的存储，第三部的读取的时候，请不要修改数据，仅仅完善一个读和存的操作就可以了。

    三、主动给用户发送消息。

        1、类简介：用户输入文本、图片、语音、音乐、视频等消息，以及关注、取消关注，上报地理位置等事件后，服务器被动给出应答。

        2、使用命名空间：use LaneWeChat\Core\ResponsePassive;

        3、参数  $tousername = "你的公众号Id";  在变量$require['tousername']中
                $mediaId = "通过上传多媒体文件，得到的id。";

        4、发送文本内容
            ResponseInitiative::text($tousername, '文本消息内容');

        5、发送图片
            ResponseInitiative::image($tousername, $mediaId);

        6、发送语音
            ResponseInitiative::voice($tousername, $mediaId);

        7、发送视频
            ResponseInitiative::video($tousername, $mediaId, '视频描述', '视频标题');

        8、发送地理位置
            ResponseInitiative::music($tousername, '音乐标题', '音乐描述', '音乐链接', '高质量音乐链接，WIFI环境优先使用该链接播放音乐', '缩略图的媒体id，通过上传多媒体文件，得到的id');

        9、发送图文消息
            1）创建图文消息内容
                $tuwenList = array();
                $tuwenList[] = array('title'=>'标题1', 'description'=>'描述1', 'pic_url'=>'图片URL1', 'url'=>'点击跳转URL1');
                $tuwenList[] = array('title'=>'标题2', 'description'=>'描述2', 'pic_url'=>'图片URL2', 'url'=>'点击跳转URL2');
            2）构建图文消息格式
                $itemList = array();
                foreach($tuwenList as $tuwen){
                    $itemList[] = ResponseInitiative::newsItem($tuwen['title'], $tuwen['description'], $tuwen['pic_url'], $tuwen['url']);
                }
            3）发送图文消息
                ResponseInitiative::news($tousername, $itemList);

    四、用户及用户组管理。

        1、类简介：获取粉丝列表，创建\修改用户组，讲用户添加\移除到用户组。

        2、使用命名空间：use LaneWeChat\Core\UserManage;

        3、参数  $openId = '用户和微信公众号的唯一ID';    在变量$require['openid']中
                $mediaId = "通过上传多媒体文件，得到的id。";
                $groupId = '分组ID';    在添加新分组、获取分组列表的时候可以得到

        4、分组管理 - 创建分组
            UserManage::createGroup('分组名');

        5、分组管理 - 获取分组列表
            UserManage::getGroupList();

        6、分组管理 - 查询用户所在分组
            UserManage::getGroupByOpenId($openId);

        7、分组管理 - 修改分组名
            UserManage::editGroupName($groupId, '新的组名');

        8、分组管理 - 移动用户分组
            UserManage::editUserGroup($openId, $groupId);

        9、用户管理 - 获取用户基本信息
            UserManage::getUserInfo($openId);

        10、用户管理 - 获取关注者列表
            UserManage::getFansList($next_openId='');

        11、用户管理 - 获取网络状态
            UserManage::getNetworkState();

        12、设置备注名 开发者可以通过该接口对指定用户设置备注名，该接口暂时开放给微信认证的服务号。
            UserManage::setRemark($openId, $remark);
            $openId：用户的openId
            $remark：新的昵称

        13、关于获取用户信息的新亮点 - unionId：
            获取用户信息是根据openId获取，同一个微信用户对于不同的公众号，是不同的openId。那问题就来了，如果你有多个公众号，想要共享一份用户数据，可是同一个用户在不同的公众号是不同的openId，我们无法判断是否是同一个用户，现在微信引入了UnionId的概念。
            如果开发者有在多个公众号，或在公众号、移动应用之间统一用户帐号的需求，需要前往微信开放平台（open.weixin.qq.com）绑定公众号后，才可利用UnionID机制来满足上述需求。
            在绑定了公众号后，我们根据openId获取用户信息的时候，会新增一个字段“unionid”，只要是同一个用户，在不同的公众号用不同的openId获取用户信息的时候unionid是相同的。
            此功能不需要新增/修改代码，只需要在微信开放平台绑定公众号就可以了。仍旧使用获取用户信息接口UserManage::getUserInfo($openId);

    五、网页授权。

        1、类简介：在网页中获取来访用户的数据。

        2、使用命名空间：use LaneWeChat\Core\WeChatOAuth;

        3、参数  $openId = '用户和微信公众号的唯一ID';           在变量$require['openid']中
                $mediaId = "通过上传多媒体文件，得到的id。";
                $groupId = '分组ID';                         在添加新分组、获取分组列表的时候可以得到

        4、获取CODE。
            参数：$scope：snsapi_base不弹出授权页面，只能获得OpenId;snsapi_userinfo弹出授权页面，可以获得所有信息
            参数：$redirect_uri：将会跳转到redirect_uri/?code=CODE&state=STATE 通过GET方式获取code和state。获取CODE时，发送请求和参数给微信服务器，微信服务器会处理后将跳转到本参数指定的URL页面
            WeChatOAuth::getCode($redirect_uri, $state=1, $scope='snsapi_base');

        5、通过code换取网页授权access_token（access_token网页版）。首先请注意，这里通过code换取的网页授权access_token,与基础支持中的access_token不同。公众号可通过下述接口来获取网页授权access_token。如果网页授权的作用域为snsapi_base，则本步骤中获取到网页授权access_token的同时，也获取到了openid，snsapi_base式的网页授权流程即到此为止。
            参数：$code getCode()获取的code参数。$code = $_GET['code'];
            WeChatOAuth::getAccessTokenAndOpenId($code);

        6、刷新access_token（如果需要）
            由于access_token拥有较短的有效期，当access_token超时后，可以使用refresh_token进行刷新，refresh_token拥有较长的有效期（7天、30天、60天、90天），当refresh_token失效的后，需要用户重新授权。
            WeChatOAuth::refreshToken($refreshToken);
                $refreshToken：通过本类的第二个方法getAccessTokenAndOpenId可以获得一个数组，数组中有一个字段是refresh_token，就是这里的参数

        7、拉取用户信息(需scope为 snsapi_userinfo)
            如果网页授权作用域为snsapi_userinfo，则此时开发者可以通过access_token和openid拉取用户信息了。
            WeChatOAuth::getUserInfo($accessToken, $openId, $lang='zh_CN');
                $accessToken:网页授权接口调用凭证。通过本类的第二个方法getAccessTokenAndOpenId可以获得一个数组，数组中有一个字段是access_token，就是这里的参数。注意：此access_token与基础支持的access_token不同。
                $openId:用户的唯一标识
                $lang:返回国家地区语言版本，zh_CN 简体，zh_TW 繁体，en 英语

        8、检验授权凭证（access_token）是否有效
            WeChatOAuth::checkAccessToken($accessToken, $openId){
                $accessToken：网页授权接口调用凭证。通过本类的第二个方法getAccessTokenAndOpenId可以获得一个数组，数组中有一个字段是access_token，就是这里的参数。注意：此access_token与基础支持的access_token不同。

    六、多媒体上传下载

        1、类简介：在网页中获取来访用户的数据。上传的多媒体文件有格式和大小限制，如下：
            * 图片（image）: 1M，支持JPG格式
            * 语音（voice）：2M，播放长度不超过60s，支持AMR\MP3格式
            * 视频（video）：10MB，支持MP4格式
            * 缩略图（thumb）：64KB，支持JPG格式
            * 媒体文件在后台保存时间为3天，即3天后media_id失效

        2、使用命名空间：use LaneWeChat\Core\Media;

        3、参数  $filename 上传的文件的绝对路径
                $type 媒体文件类型，分别有图片（image）、语音（voice）、视频（video）和缩略图（thumb）
                $mediaId = "通过上传多媒体文件，得到的id。";
                $groupId = '分组ID';                         在添加新分组、获取分组列表的时候可以得到

        4、上传：上传后，微信服务器会返回一个mediaId。
            Media::upload($filename, $type);

        5、下载：根据mediaId下载一个多媒体文件。
            Media::download($mediaId);

    七、自定义菜单

        1、类简介：添加自定义菜单。最多可以有三个一级菜单，每个一级菜单最多可以有五个菜单。一级菜单最多4个汉字，二级菜单最多7个汉字。创建自定义菜单后，由于微信客户端缓存，需要24小时微信客户端才会展现出来。建议测试时可以尝试取消关注公众账号后再次关注，则可以看到创建后的效果。

        警告：设置菜单Menu::setMenu($menuList)参数结构和返回值重写，自1.4版本起不向下兼容。

        注意：所有新增的菜单类型（除了click类型和view类型），仅支持微信iPhone5.4.1以上版本，和Android5.4以上版本的微信用户，旧版本微信用户点击后将没有回应，开发者也不能正常接收到事件推送。

        摘自微信官方网站：目前自定义菜单接口可实现两种类型按钮，如下：

            click：
                用户点击click类型按钮后，微信服务器会通过消息接口推送消息类型为event的结构给开发者，并且带上按钮中开发者填写的key值，开发者可以通过自定义的key值与用户进行交互；

            view：
                用户点击view类型按钮后，微信客户端将会打开开发者在按钮中填写的url值（即网页链接），达到打开网页的目的，建议与网页授权获取用户基本信息接口结合，获得用户的登入个人信息。

            总结一下哦，就是微信的菜单分两种，一种是view型，就是你设置一个网址，点了这个菜单之后就跳到你设置的网址去了。另一种就是click型，你设置一个key，然后用户点击的时候会通过本框架唯一入口wechat.php发送一个消息类型为event的请求，在wechatrequest.lib.php文件下的eventClick方法中可以使用。

            1、新增“scancode_push：扫码推事件”类型菜单
                用户点击按钮后，微信客户端将调起扫一扫工具，完成扫码操作后显示扫描结果（如果是URL，将进入URL），且会将扫码的结果传给开发者，开发者可以下发消息。

            2、新增“scancode_waitmsg：扫码推事件且弹出‘消息接收中’提示框”类型菜单
                用户点击按钮后，微信客户端将调起扫一扫工具，完成扫码操作后，将扫码的结果传给开发者，同时收起扫一扫工具，然后弹出“消息接收中”提示框，随后可能会收到开发者下发的消息。

            3、新增“pic_sysphoto：弹出系统拍照发图”类型菜单
                用户点击按钮后，微信客户端将调起系统相机，完成拍照操作后，会将拍摄的相片发送给开发者，并推送事件给开发者，同时收起系统相机，随后可能会收到开发者下发的消息。

            4、新增“pic_photo_or_album：弹出拍照或者相册发图”类型菜单
                用户点击按钮后，微信客户端将弹出选择器供用户选择“拍照”或者“从手机相册选择”。用户选择后即走其他两种流程。

            5、新增“pic_weixin：弹出微信相册发图器”类型菜单
                用户点击按钮后，微信客户端将调起微信相册，完成选择操作后，将选择的相片发送给开发者的服务器，并推送事件给开发者，同时收起相册，随后可能会收到开发者下发的消息。

            6、新增“location_select：弹出地理位置选择器”类型菜单
                用户点击按钮后，微信客户端将调起地理位置选择工具，完成选择操作后，将选择的地理位置发送给开发者的服务器，同时收起位置选择工具，随后可能会收到开发者下发的消息。

            7、新增了以上6种菜单类型、view（点击跳转链接）的菜单类型的被动响应的支持。默认讲点击菜单的事件推送数据发送文本消息返回给用户。开发者请自行修改。

        2、使用命名空间：use LaneWeChat\Core\Menu;

        3、设置菜单：是所有的菜单数据全部发送一次，可不是每新增一个只发一个菜单。
            Menu::setMenu($menuList);
            $menuLis 是菜单列表，结构如下：
            $menuList ＝ array(
                array('id'=>'1', 'pid'=>'0', 'name'=>'顶级分类一', 'type'=>'', 'code'=>''),
                array('id'=>'2', 'pid'=>'1', 'name'=>'分类一子分类一', 'type'=>'click', 'code'=>'lane_wechat_menu_1_1'),
                array('id'=>'3', 'pid'=>'1', 'name'=>'分类一子分类二', 'type'=>'1', 'code'=>'http://www.lanecn.com'),
                array('id'=>'4', 'pid'=>'0', 'name'=>'顶级分类二', 'type'=>'1', 'code'=>'http://www.php.net/'),
                array('id'=>'5', 'pid'=>'0', 'name'=>'顶级分类三', 'type'=>'2', 'code'=>'lane_wechat_menu_3'),
            );
            'id'是您的系统中对分类的唯一编号；
            'pid'是该分类的上级分类，顶级分类则填写0；
            'name'是分类名称；
            'type'是菜单类型，如果该分类下有子分类请务必留空；
                'type'的值从以下类型中选择：click、view、scancode_push、scancode_waitmsg、pic_sysphoto、pic_photo_or_album、pic_weixin、location_select。
            'code'是view类型的URL或者其他类型的自定义key，如果该分类下有子分类请务必留空。

        4、获取微信菜单：获取到的是已经设置过的菜单列表，格式为Json，是微信服务器返回的原始数据。
            Menu::getMenu();

        5、删除微信菜单：将会删除设置过的所有菜单（一键清空）。
            Menu::delMenu();

    八、高级群发接口

        1、类简介：根据分组、openId列表进行群发（推送）。图文消息需要先将图文消息当作一个素材上传，然后再群发，其他类型的消息直接群发即可。

        注意：推送后用户到底是否成功接受，微信会向公众号推送一个消息。消息类型为事件消息，可以在lanewechat/wechatrequest.lib.php文件中的方法eventMassSendJobFinish(&$request)中收到这条消息。

        2、使用命名空间：use LaneWeChat\Core\AdvancedBroadcast;

        3、上传图文消息。创建一个图文消息，保存到微信服务器，可以得到一个id代表这个图文消息，发送的时候根据这个id发送就可以了。
            Menu::uploadNews($articles);
            $articles 是图文消息列表，结构如下：
            $articles = array(
                array('thumb_media_id'=>'多媒体ID，由多媒体上传接口获得' , 'author'=>'作者', 'title'=>'标题', 'content_source_url'=>'www.lanecn.com', 'digest'=>'摘要', 'show_cover_pic'=>'是否设置为封面（0或者1）'),
                array('thumb_media_id'=>'多媒体ID，由多媒体上传接口获得' , 'author'=>'作者', 'title'=>'标题', 'content_source_url'=>'www.lanecn.com', 'digest'=>'摘要', 'show_cover_pic'=>'是否设置为封面（0或者1）'),
            );
            'thumb_media_id'多媒体ID，由多媒体上传接口获得：Media::upload($filename, $type);
            'author'作者
            'title'标题
            'content_source_url'一个URL，点击“阅读全文”跳转的地址
            'digest'摘要
            'show_cover_pic'0或1，是否设置为封面。
        下面的方法，图文消息的参数mediaId是由上面这个方法（3）Menu::uploadNews($articles);获得的，其他的mediaId是多媒体上传获得的Media::upload($filename, $type);
        根据分组群发的所有接口最后一个参数,$isToAll，默认未false。使用true且成功群发，会使得此次群发进入历史消息列表。

        4、根据分组进行群发 - 发送图文消息：
            AdvancedBroadcast::sentNewsByGroup($groupId, $mediaId, $isToAll=false);

        5、根据分组进行群发 - 发送文本消息
            AdvancedBroadcast::sentTextByGroup($groupId, $content, $isToAll=false);

        6、根据分组进行群发 - 发送语音消息
            AdvancedBroadcast::sentVoiceByGroup($groupId, $mediaId, $isToAll=false);

        7、根据分组进行群发 - 发送图片消息
            AdvancedBroadcast::sentImageByGroup($groupId, $mediaId, $isToAll=false);

        8、根据分组进行群发 - 发送视频消息
            AdvancedBroadcast::sentVideoByGroup($mediaId, $title, $description, $groupId, $isToAll=false);

        9、根据OpenID列表群发 - 发送图文消息
            AdvancedBroadcast::sentNewsByOpenId($toUserList, $mediaId);

        10、根据OpenID列表群发 - 发送文本消息
            AdvancedBroadcast::sentTextByOpenId($toUserList, $content);

        11、根据OpenID列表群发 - 发送语音消息
            AdvancedBroadcast::sentVoiceByOpenId($toUserList, $mediaId);

        12、根据OpenID列表群发 - 发送图片消息
            AdvancedBroadcast::sentImageByOpenId($toUserList, $mediaId);

        13、根据OpenID列表群发 - 发送视频消息
            AdvancedBroadcast::sentVideoByOpenId($toUserList, $mediaId, $title, $description);

        14、删除群发
            请注意，只有已经发送成功的消息才能删除删除消息只是将消息的图文详情页失效，已经收到的用户，还是能在其本地看到消息卡片。 另外，删除群发消息只能删除图文消息和视频消息，其他类型的消息一经发送，无法删除。
            AdvancedBroadcast::delete($msgId);
            $msgId:以上的群发接口成功时都会返回msg_id这个字段

        15、预览图文消息
            AdvancedBroadcast::previewNewsByGroup($openId, $mediaId);

        16、预览文本消息
            AdvancedBroadcast::previewTextByGroup($openId, $content);

        17、预览语音消息
            AdvancedBroadcast::previewVoiceByGroup($openId, $mediaId);

        18、预览图片消息
            AdvancedBroadcast::previewImageByGroup($openId, $mediaId);

        19、预览视频消息
            AdvancedBroadcast::previewVideoByGroup($mediaId, $title, $description, $openId);

        20、查询群发消息发送状态【订阅号与服务号认证后均可用】
            AdvancedBroadcast::getStatus($openId, $mediaId);

    九、多客服接口

        1、类简介：客服功能接口。

        2、使用命名空间：use LaneWeChat\Core\CustomService;

        3、获取客服聊天记录接口，有分页，一次获取一页，一页最多1000条。不能跨日。
            在需要时，开发者可以通过获取客服聊天记录接口，获取多客服的会话记录，包括客服和用户会话的所有消息记录和会话的创建、关闭等操作记录。利用此接口可以开发如“消息记录”、“工作监控”、“客服绩效考核”等功能。
            CustomService::getRecord($startTime, $endTime, $pageIndex=1, $pageSize=1000, $openId='')
            'startTime':查询开始时间，UNIX时间戳
            'startTime':查询结束时间，UNIX时间戳，每次查询不能跨日查询

        4、将用户发送的消息转发到客服：
            调用ResponsePassive::forwardToCustomService($fromusername, $tousername)。
            如用户在微信给公众号发送一条文本消息“iphone 6 多少钱？”，我们就可以在lanewechat/wechatrequest.lib.php文件中的方法text(&$request)中收到这条消息（如果不了解为什么会在这里收到文本消息，请重头再看文档）。
            然后在text(&$request)方法中，我们可以调用ResponsePassive::forwardToCustomService($request['fromusername'], $request['tousername'])。那么刚才用户发的“iphone 6 多少钱？”就会被转发到客服系统，在微信的客服客户端中就可以收到了。

        5、添加客服帐号
            必须先在公众平台官网为公众号设置微信号后才能使用该能力。
            开发者可以通过本接口为公众号添加客服账号，每个公众号最多添加10个客服账号。
            CustomService::addAccount($kfAccount, $nickname, $password)
                $kfAccount String 完整客服账号，格式为：账号前缀@公众号微信号
                $nickname String 昵称
                $password String 密码

        6、修改客服帐号
            必须先在公众平台官网为公众号设置微信号后才能使用该能力。
            CustomService::editAccount($kfAccount, $nickname, $password)
                $kfAccount String 完整客服账号，格式为：账号前缀@公众号微信号
                $nickname String 昵称
                $password String 密码

        7、删除客服帐号
            必须先在公众平台官网为公众号设置微信号后才能使用该能力。
            CustomService::delAccount($kfAccount, $nickname, $password)
                $kfAccount String 完整客服账号，格式为：账号前缀@公众号微信号
                $nickname String 昵称
                $password String 密码

        8、获取所有客服账号
            必须先在公众平台官网为公众号设置微信号后才能使用该能力。
            CustomService::getAccountList($kfAccount, $nickname, $password)
                $kfAccount String 完整客服账号，格式为：账号前缀@公众号微信号
                $nickname String 昵称
                $password String 密码

        9、设置客服帐号的头像
            必须先在公众平台官网为公众号设置微信号后才能使用该能力。
            CustomService::setAccountImage($kfAccount, $imagePath)
                $kfAccount String 完整客服账号，格式为：账号前缀@公众号微信号
                $imagePath String 待上传的头像文件路径

    十、智能接口

        1、类简介：智能接口。

        2、使用命名空间：use LaneWeChat\Core\IntelligentInterface;

        3、语义理解：比如输入文本串，如“查一下明天从北京到上海的南航机票”就可以收到关于这个问题的答案。
            单类别意图比较明确，识别的覆盖率比较大，所以如果只要使用特定某个类别，建议将category只设置为该类别。
            IntelligentInterface::semanticSemproxy($query, $category, $openId, $latitude='', $longitude='', $region='', $city=''){
            $query 输入文本串，如“查一下明天从北京到上海的南航机票"
            $category String 需要使用的服务类型，如“flight,hotel”，多个用“,”隔开，不能为空。详见《接口协议文档》
            $latitude Float 纬度坐标，与经度同时传入；与城市二选一传入。详见《接口协议文档》
            $longitude Float 经度坐标，与纬度同时传入；与城市二选一传入。详见《接口协议文档》
            $region String 区域名称，在城市存在的情况下可省；与经纬度二选一传入。详见《接口协议文档》
            $city 城市名称，如“北京”，与经纬度二选一传入
            $openId
            《接口协议文档》：http://mp.weixin.qq.com/wiki/images/1/1f/微信语义理解协议文档.zip

    十一、推广支持

        1、类简介：推广支持。

        2、使用命名空间：use LaneWeChat\Core\Popularize;

        3、生成带参数的二维码 - 第一步 创建二维码ticket
            获取带参数的二维码的过程包括两步，首先创建二维码ticket，然后凭借ticket到指定URL换取二维码。
            目前有2种类型的二维码，分别是临时二维码和永久二维码，
            前者有过期时间，最大为1800秒，但能够生成较多数量，后者无过期时间，数量较少（目前参数只支持1--100000）。
            两种二维码分别适用于帐号绑定、用户来源统计等场景。
            Popularize::createTicket($type, $expireSeconds, $sceneId);
            $type Int 临时二维码类型为1，永久二维码类型为2
            $expireSeconds Int 过期时间，只在类型为临时二维码时有效。最大为1800，单位秒
            $sceneId Int 场景值ID，临时二维码时为32位非0整型，永久二维码时最大值为100000（目前参数只支持1--100000）

        4、生成带参数的二维码 - 第二步 通过ticket换取二维码
            public static function getQrcode($ticket, $filename='');
            $ticket Popularize::createTicket()获得的
            $filename String 文件路径，如果不为空，则会创建一个图片文件，二维码文件为jpg格式，保存到指定的路径
            返回值：如果传递了第二个参数filename则会在filename指定的路径生成一个二维码的图片。如果第二个参数filename为空，则直接echo本函数的返回值，并在调用页面添加header('Content-type: image/jpg');，将会展示出一个二维码的图片。

        5、将一条长链接转成短链接。

           主要使用场景：开发者用于生成二维码的原链接（商品、支付二维码等）太长导致扫码速度和成功率下降，将原长链接通过此接口转成短链接再生成二维码将大大提升扫码速度和成功率。
           Popularize::long2short($longUrl);
           $longUrl String 需要转换的长链接，支持http://、https://、weixin://wxpay 格式的url

    十二、模板消息接口

        1、类简介：模板消息仅用于公众号向用户发送重要的服务通知，只能用于符合其要求的服务场景中，如信用卡刷卡通知，商品购买成功通知等。不支持广告等营销类消息以及其它所有可能对用户造成骚扰的消息。

        关于使用规则，请注意：
            1、所有服务号都可以在功能->添加功能插件处看到申请模板消息功能的入口，但只有认证后的服务号才可以申请模板消息的使用权限并获得该权限；
            2、需要选择公众账号服务所处的2个行业，每月可更改1次所选行业；
            3、在所选择行业的模板库中选用已有的模板进行调用；
            4、每个账号可以同时使用15个模板。
            5、当前每个模板的日调用上限为10000次。

        关于接口文档，请注意：
            1、模板消息调用时主要需要模板ID和模板中各参数的赋值内容；
            2、模板中参数内容必须以".DATA"结尾，否则视为保留字；
            3、模板保留符号"{{ }}"。

        2、使用命名空间：use LaneWeChat\Core\TemplateMessage;

        3、向用户推送模板消息
            TemplateMessage::sendTemplateMessage($data, $touser, $templateId, $url, $topcolor='#FF0000'){
                $data = array(
                       'first'=>array('value'=>'您好，您已成功消费。', 'color'=>'#0A0A0A')
                       'keynote1'=>array('value'=>'巧克力', 'color'=>'#CCCCCC')
                       'keynote2'=>array('value'=>'39.8元', 'color'=>'#CCCCCC')
                       'keynote3'=>array('value'=>'2014年9月16日', 'color'=>'#CCCCCC')
                       'keynote3'=>array('value'=>'欢迎再次购买。', 'color'=>'#173177')
                );
                $touser 接收方的OpenId。
                $templateId 模板Id。在公众平台线上模板库中选用模板获得ID
                $url URL
                $topcolor 顶部颜色，可以为空。默认是红色

            注意：推送后用户到底是否成功接受，微信会向公众号推送一个消息。消息类型为事件消息，可以在lanewechat/wechatrequest.lib.php文件中的方法eventTemplateSendJobFinish(&$request)中收到这条消息。

        4、设置行业
            TemplateMessage::setIndustry($industryId1, $industryId2){
                $industryId1 公众号模板消息所属行业编号 请打开连接查看行业编号 http://mp.weixin.qq.com/wiki/17/304c1885ea66dbedf7dc170d84999a9d.html#.E8.AE.BE.E7.BD.AE.E6.89.80.E5.B1.9E.E8.A1.8C.E4.B8.9A
                $industryId2 公众号模板消息所属行业编号。在公众平台线上模板库中选用模板获得ID

        5、获得模板ID
            TemplateMessage::getTemplateId($templateIdShort)
                $templateIdShort 模板库中模板的编号，有“TM**”和“OPENTMTM**”等形式

    十三、安全性

        1、类简介：安全性相关接口

        2、使用命名空间：use LaneWeChat\Core\Auth;

        3、获取微信服务器IP列表，用于验证每次的请求来源是否是微信服务器。
            Auth::getWeChatIPList();

    十四、自动回复

            1、类简介：自动回复

            2、使用命名空间：use LaneWeChat\Core\AutoReply;

            3、获取自动回复规则
                AutoReply::getRole($industryId1, $industryId2);
                返回结果与字段说明请查看http://mp.weixin.qq.com/wiki/7/7b5789bb1262fb866d01b4b40b0efecb.html

实例示范：

    一、通过网页授权获得用户信息

        场景：用户点击了我的自定义菜单，或者我发送的文本消息中包含一个URL，用户打开了我的微信公众号的网页版，我需要获取用户的信息。

        代码：

        <?php
            use LaneWeChat\Core\WeChatOAuth;
            use LaneWeChat\Core\UserManage;

            //第一步，获取CODE
            WeChatOAuth::getCode('http://www.lanecn.com/index.php', 1, 'snsapi_base');
            //此时页面跳转到了http://www.lanecn.com/index.php，code和state在GET参数中。
            $code = $_GET['code'];
            //第二步，获取access_token网页版
            $openId = WeChatOAuth::getAccessTokenAndOpenId($code);
            //第三步，获取用户信息
            $userInfo = UserManage::getUserInfo($openId['openid']);
        ?>

    二、被动响应用户 - 发送图文消息

        场景描述：用户给我们的公众号发送了一条消息，我们的公众号被动响应，给用户回复一条图文消息。

        场景举例：用户给我们的公众号发送了“周末聚会”，我们的公众号给用户回复了一条图文消息，有十条，每一条都是一个标题和图片，点击可以连接到一个地址。

        代码：

            //图文列表逐条放入数组
            $tuwenList = array();
            $tuwenList[] = array(
                'title' => '标题：聚会地点一故宫',
                'description' => '描述：还有人去故宫聚会啊',
                'pic_url' => 'http://www.gugong.com/logo.jpg',
                'url' => 'http://www.lanecn.com/',
            );
            $tuwenList[] = array(
                'title' => '标题：聚会地点一八达岭',
                'description' => '描述：八达岭是聚会的吗？是去看人挤人的！',
                'pic_url' => 'http://www.badaling.com/logo.jpg',
                'url' => 'http://www.lanecn.com/',
            );
            $item = array();
            //构建图文列表
            foreach($tuwenList as $tuwen){
                $item[] = ResponsePassive::newsItem($tuwen['title'], $tuwen['description'], $tuwen['pic_url'], $tuwen['url']);
            }
            //发送图文列表
            ResponsePassive::news($request['fromusername'], $request['tousername'], $item);

    三、群发图文消息

        场景描述：用户给我们的公众号发送了一条消息，我们的公众号被动响应，给用户回复一条图文消息。

        场景举例：用户给我们的公众号发送了“周末聚会”，我们的公众号给用户回复了一条图文消息，有十条，每一条都是一个标题和图片，点击可以连接到一个地址。

        代码：

            $fansList = \LaneWeChat\Core\UserManage::getFansList();
            //上传图片
            $menuId = \LaneWeChat\Core\Media::upload('/var/www/baidu_jgylogo3.jpg', 'image');
            if(empty($menuId['media_id'])){
                die('error');
            }
            //上传图文消息
            $list = array();
            $list[] = array('thumb_media_id'=>$menuId['media_id'] , 'author'=>'作者', 'title'=>'标题', 'content_source_url'=>'www.lanecn.com', 'digest'=>'摘要', 'show_cover_pic'=>'1');
            $list[] = array('thumb_media_id'=>$menuId['media_id'] , 'author'=>'作者', 'title'=>'标题', 'content_source_url'=>'www.lanecn.com', 'digest'=>'摘要', 'show_cover_pic'=>'0');
            $list[] = array('thumb_media_id'=>$menuId['media_id'] , 'author'=>'作者', 'title'=>'标题', 'content_source_url'=>'www.lanecn.com', 'digest'=>'摘要', 'show_cover_pic'=>'0');
            $mediaId = \LaneWeChat\Core\AdvancedBroadcast::uploadNews($list);
            //给粉丝列表的用户群发图文消息
            $result = \LaneWeChat\Core\AdvancedBroadcast::sentNewsByOpenId($fansList['data']['openid'], $mediaId);

    四、推送模板消息

        场景描述：公众号推送的模板消息，比如领取红包、滴滴打车红包领取、大众点评微信支付等

        场景举例：我们在实体店的一家服装店买了新衣服，而我们又是会员，他们检测到会员的手机号消费了，有新积分增加，而这个手机号又关注了这家服装店的微信公众号，根据手机号可以在服装店自己的数据库中查到微信粉丝openId，这个时候就会给这个用户发送一个模板消息。

        代码：

            <?php
            include 'lanewechat.php';

            $data = array(
                 'first'=>array('value'=>'您好，您已成功消费。', 'color'=>'#0A0A0A')
                 'keynote1'=>array('value'=>'巧克力', 'color'=>'#CCCCCC')
                 'keynote2'=>array('value'=>'39.8元', 'color'=>'#CCCCCC')
                 'keynote3'=>array('value'=>'2014年9月16日', 'color'=>'#CCCCCC')
                 'keynote3'=>array('value'=>'欢迎再次购买。', 'color'=>'#173177')
            );

            //$touser 接收方的OpenId。
            //$templateId 模板Id。在公众平台线上模板库中选用模板获得ID
            //$url URL 点击查看的时候跳转到URL。
            //$topcolor 顶部颜色，可以为空。默认是红色
            \LaneWeChat\Core\TemplateMessage::sendTemplateMessage($data, $touser, $templateId, $url, $topcolor='#FF0000');

    五、添加自定义菜单

        场景描述：微信公众号底部的导航栏按钮

        场景举例：自定义菜单可以更加快捷方便的为用户服务。而不需要用户每次都要打字发送消息来获取所需要的信息。轻轻一点按钮，马上拥有！

        注：微信官方仅供认证号使用自定义菜单。

        代码：

            <?php
            include 'lanewechat.php';

            $menuList = array(
                array('id'=>'1', 'pid'=>'0', 'name'=>'菜单1', 'type'=>'', 'code'=>''),
                array('id'=>'2', 'pid'=>'0', 'name'=>'菜单2', 'type'=>'', 'code'=>''),
                array('id'=>'3', 'pid'=>'0', 'name'=>'地理位置', 'type'=>'location_select', 'code'=>'key_7'),
                array('id'=>'4', 'pid'=>'1', 'name'=>'点击推事件', 'type'=>'click', 'code'=>'key_1'),
                array('id'=>'5', 'pid'=>'1', 'name'=>'跳转URL', 'type'=>'view', 'code'=>'http://www.lanecn.com/'),
                array('id'=>'6', 'pid'=>'2', 'name'=>'扫码推事件', 'type'=>'scancode_push', 'code'=>'key_2'),
                array('id'=>'7', 'pid'=>'2', 'name'=>'扫码等收消息', 'type'=>'scancode_waitmsg', 'code'=>'key_3'),
                array('id'=>'8', 'pid'=>'2', 'name'=>'系统拍照发图', 'type'=>'pic_sysphoto', 'code'=>'key_4'),
                array('id'=>'9', 'pid'=>'2', 'name'=>'弹拍照或相册', 'type'=>'pic_photo_or_album', 'code'=>'key_5'),
                array('id'=>'10', 'pid'=>'2', 'name'=>'弹微信相册', 'type'=>'pic_weixin', 'code'=>'key_6'),
            );

            $result = \LaneWeChat\Core\Menu::setMenu($menuList);

    六、页面展示二维码

        场景描述：在网页中展示微信公众号的二维码

        场景举例：太多了吧，就不说了…

        代码：

            <?php
            include 'lanewechat.php';

            header('Content-type: image/jpg');
            $ticket = \LaneWeChat\Core\Popularize::createTicket(1, 1800, 1);
            $ticket = $ticket['ticket'];
            $qrcode = \LaneWeChat\Core\Popularize::getQrcode($ticket);
            echo $qrcode;
    
    七、补充

        微信平台原来的客服软件近期将失效，所以部分功能可能受影响，对于腾讯是否会取消相关接口访问权限待定。