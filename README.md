框架名称：LaneWeChat

框架简介：这是一个为快速开发微信应用而生的PHP框架。将微信的开发者功能根据文档进行了封装。为了快速开发的目的，开发者完全不需要要知道具体是如何实现的，只需要简单的调用方法即可

开发语言：PHP

版本要求：原则PHP5.3以上

版本规避：若版本低于PHP5.3，则删除本框架所有页面开头namespace一行即可。

命名空间：本框架的命名空间均为LaneWeChat开头。




Developer Blog：http://www.lanecn.com

文档地址：<a href="http://www.lanecn.com/article/main/aid-65">http://www.lanecn.com/article/main/aid-65</a>



更新日志：

    2014-08-17：1.2版本。新增自定义菜单功能

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

    1、本框架以代码包的插件形式放在项目的目录中即可。

    2、配置项：打开根目录下的config.php，修改定义常量WECHAT_APPID，WECHAT_APPSECRET，WECHAT_URL。其中前两项可以在微信公众号官网的开发者页面中找到，而WECHAT_URL是你微信项目的URL，以http://开头

    3、本框架的唯一入口为根目录下的wechat.php

    4、首次使用时，请打开根目录下的wechat.php，注释掉21行，并且打开注释第24行。

    5、在微信开发者-填写服务器配置页面，填写URL为http://www.lanecn.com/wechat.php，保证该URL可以通过80端口正常访问（微信服务器目前只支持80端口），并且将Token填写为config.php中的WECHAT_TOKEN常量的内容（可以修改）。

    6、微信服务器在第4步验证通过后，反向操作第4步，即注释掉第24行，打开注释第21行。至此，安装配置完成。




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

        3、参数  $tousername = "你的公众号Id";                 在变量$require['tousername']中

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

        3、参数  $openId = '用户和微信公众号的唯一ID';           在变量$require['openid']中

                $mediaId = "通过上传多媒体文件，得到的id。";

                $groupId = '分组ID';                         在添加新分组、获取分组列表的时候可以得到

        4、分组管理 - 创建分组

            UserManage::createGroup('分组名');

        5、分组管理 - //获取分组列表

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

            摘自微信官方网站：目前自定义菜单接口可实现两种类型按钮，如下：

            click：

                用户点击click类型按钮后，微信服务器会通过消息接口推送消息类型为event的结构给开发者，并且带上按钮中开发者填写的key值，开发者可以通过自定义的key值与用户进行交互；

            view：

                用户点击view类型按钮后，微信客户端将会打开开发者在按钮中填写的url值	（即网页链接），达到打开网页的目的，建议与网页授权获取用户基本信息接口结合，获得用户的登入个人信息。

            总结一下哦，就是微信的菜单分两种，一种是view型，就是你设置一个网址，点了这个菜单之后就跳到你设置的网址去了。另一种就是click型，你设置一个key，然后用户点击的时候会通过本框架唯一入口wechat.php发送一个消息类型为event的请求，在wechatrequest.lib.php文件下的eventClick方法中可以使用。

        2、使用命名空间：use LaneWeChat\Core\Menu;

        3、设置菜单：是所有的菜单数据全部发送一次，可不是每新增一个只发一个菜单。

            Menu::setMenu($menuList);

            $menuLis 是菜单列表，结构如下：

            $menuList ＝ array(

                                array('id'=>'1', 'pid'=>'0', 'name'=>'顶级分类一', 'type'=>'', 'code'=>''),

                                array('id'=>'2', 'pid'=>'1', 'name'=>'分类一子分类一', 'type'=>'2', 'code'=>'lane_wechat_menu_1_1'),

                                array('id'=>'3', 'pid'=>'1', 'name'=>'分类一子分类二', 'type'=>'1', 'code'=>'http://www.lanecn.com'),

                                array('id'=>'4', 'pid'=>'0', 'name'=>'顶级分类二', 'type'=>'1', 'code'=>'http://www.php.net/'),

                                array('id'=>'5', 'pid'=>'0', 'name'=>'顶级分类三', 'type'=>'2', 'code'=>'lane_wechat_menu_3'),

                            );

            'id'是您的系统中对分类的唯一编号；

            'pid'是该分类的上级分类，顶级分类则填写0；

            'name'是分类名称；

            'type'是菜单类型，数字1或者2，1是view类型，2是click类型，如果该分类下有子分类请务必留空；

            'code'是view类型的URL或者click类型的自定义key，如果该分类下有子分类请务必留空。

        4、获取微信菜单：获取到的是已经设置过的菜单列表，格式为Json，是微信服务器返回的原始数据。

            Menu::getMenu();

        5、删除微信菜单：将会删除设置过的所有菜单（一键清空）。

            Menu::delMenu();




实例示范：

    1、通过网页授权获得用户信息

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