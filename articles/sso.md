# SSO调研和部署相关

> 登录是服务化必不可少的一步, 行业大多通过单点登录(SSO)来解决此问题, 当然不同公司实现的方式也不相同.

### 现有登录流程

```flow
st=>start: 点击菜单
end=>end: 结束
loginCheck=>condition: 是否登录
success=>operation: 访问成功
failed=>operation: 访问失败
login=>condition: 登录

st->loginCheck
loginCheck(yes)->success
loginCheck(no)->login
login(yes)->success
login(no)->failed
success->end
failed->end
```


### 服务化后的登录流程

```flow
start=>start: 点击菜单
end=>end: 结束
loginCheck=>condition: 是否登录
success=>operation: 访问成功
ssoAuth=>condition: SSO验证
ssoLogin=>condition: SSO登录
failed=>operation: 访问失败
ssoNotify=>operation: SSO通知

start->loginCheck
loginCheck(yes)->success
loginCheck(no)->ssoAuth
ssoAuth(yes)->success
ssoAuth(no)->ssoLogin
ssoLogin(yes)->ssoNotify->success
ssoLogin(no)->failed
failed->end
success->end
```


```sequence
APP->SSO: 验证是否登录
Note right of SSO: 验证是否登录
SSO->APP: 验证失败

APP->SSO: 登录
Note right of SSO: 登录验证
SSO->APP: 通知应用登录成功

APP->SSO: 验证是否登录
Note right of SSO: 验证是否登录
SSO->APP: 验证成功
Note left of APP: 重置APP的 session id
```


### 完整的SSO登录时序图和流程图
```sequence
浏览器->客户端: 1. 用户请求
客户端->客户端: 2. 验证是否已经登录
客户端->SSO: 3. 没有登录,重定向至SSO服务器
SSO->SSO: 4. 登录流程
SSO->客户端: 5. 携带凭据重定向回客户端
客户端->SSO: 6.验证凭据是否有效
SSO->客户端: 7. 有效则正常显示页面
客户端->浏览器: 8. 完成
```

###### 对应流程图
```flow
start=>start: 访问页面
end=>end: 结束
getToken=>operation: 截取token
checkToken=>condition: token是否有效
handle=>operation: 后续动作
ssoLogin=>operation: 登录
syncToken=>operation: 登录成功同步token至客户端
saveToken=>operation: 种植token

start->getToken->checkToken
checkToken(yes)->handle->end
checkToken(no)->ssoLogin->syncToken->saveToken->end
```


### 一个相对完整的APP SSO登录时序图
```sequence

App->Web: 请求需要的登录页
Web->App: 返回302跳转
App->SSO: 带token跳转到登录页
SSO->AppServer: token
AppServer->SSO: 返回用户ID
SSO->SSO: 生成用户登录信息
SSO->App: 带token302跳转
App->Web: 带token跳转到回调页
Web->SSO: 凭token请求Auth
SSO->Web: 返回用户ID等信息
Web->Web: 生成用户登录信息
Web->App: 返回请求的页面
```






