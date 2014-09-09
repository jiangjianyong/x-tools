1.ssh密钥的生成
     cd ~
      mkdir .ssh


        正在生成 DSA 参数和密钥。
        输入保存密钥的文件 (/home/Administrator/.ssh/id_dsa)：[如果使用默认位置，请按 Enter 键]
        输入密码（如果没有密码，则为空）：[请保留为空并按 Enter]
        再次输入相同的密码：[请保留为空并按 Enter]
        您的标识已经保存在 /home/Administrator/.ssh/id_dsa 中。
        公共密钥已经保存在 /home/Administrator/.ssh/id_dsa.pub 中。

A.使用cygwin的ssh-keygen生成密钥对：

           ssh-keygen -t rsa

           mv id_rsa.pub authorized_keys
           默认生成的key pair在~/.ssh目录下，密钥对的密码自己看着办

2. ~/.bashrc文件的配置
           vi  ~/.bashrc
在此文件底部添加一些代码， 如下。
find_git_branch (){
    local dir=. head
    until [ "$dir" -ef / ]; do
        if [ -f "$dir/.git/HEAD" ]; then
            head=$(< "$dir/.git/HEAD")
            if [[ $head = ref:\ refs/heads/* ]]; then
                git_branch=" -> ${head#*/*/}"
            elif [[ $head != '' ]]; then
                git_branch=" -> (detached)"
            else
                git_branch=" -> (unknow)"
            fi
            return
        fi
        dir="../$dir"
    done
    git_branch=''
}

PROMPT_COMMAND="find_git_branch; $PROMPT_COMMAND"

# Here is bash color codes you can use
  black=$'\[\e[1;30m\]'
    red=$'\[\e[1;31m\]'
  green=$'\[\e[1;32m\]'
 yellow=$'\[\e[1;33m\]'
   blue=$'\[\e[1;34m\]'
agenta=$'\[\e[1;35m\]'
   cyan=$'\[\e[1;36m\]'
  white=$'\[\e[1;37m\]'
 normal=$'\[\e[m\]'
PS1="$white[$magenta\u$white@$green\h$white:$cyan\w$yellow\$git_branch$white]\$ $normal"

将这些代码添加到.bashrc文件之后 执行source  ~/.bashrc; 如果没有报错信息则正确， 如果由报错信息， 报错信息如下。
           1.bash: $'\r': command not found

出现原因：cygwin 脚本是用UNIX的   EOL   “\n".   而自己的脚本用了DOS的 EOL , "\n\r"
解决方法：对C:\cygwin\home\Administrator（Linux下为home/XXX）下的 .bashrc 运行   dos2unix
具体步骤：
（1）在网上下载dos2unix
（2）将dos2unix复制到C:\cygwin\home\Administrator\ns-allinone-2.xx\目录下
（3）在cygwin下将目录切换到\ns-allinone-2.xx\ dos2unix
（4）make clean
（5）make
（6）将.bashrc复制到\ns-allinone-2.xx\ dos2unix 目录下，然后运行“dos2unix .bashrc”
（7）最后，把dos2unix后的 .bashrc copy回原处即可
#####第4,5步并不是必须的， 有时可以直接去ns-allinone-2.xx\目录下执行dos2unix

           2.syntax error near unexpected token `$'{\r''

                 使用vi -b ~/.bashrc 将文件打开， 你会发现文件中包含^M这样的字符， 将他们去掉就好了
-- 3. .~/.viminfo ~/.vimrc 文件的配置

                 cp /usr/share/vim/vim71/vimrc_example.vim ~/.vimrc
  将
syntax on
set nu       着两句话添加到~/.vimrc中

默认使用UTF－8的编码，当然对多语言环境也进行了配置；
    所有命令有明确的注释，这以成为我的习惯，方便自己也方便其人；
    支持Windows Linux，公司没办法得在windows下工作。Linux是我一直的向往所以我尽量做到支持这两个系统，但配置有些设置在Linux下的VIM中无效，GVIM是没问题的。
    字体我改用适合于编程使用的等宽字体YaHei.Consolas.1.12.ttf，这是个合成的字体，中文使用雅黑英文使用Consolas。

下面的就是我的配置文件了(2011-01-24更新)，配置里用到的插件详细看这里：

" {{{
" DesCRiption: 适合自己使用的vimrc文件，for Linux/Windows, GUI/Console
" Last Change: 2011-01-23 03:00:23 Asins - asinsimple AT gmail DOT com
" Author:      Assins - asinsimple AT gmail DOT com
"              Get latest vimrc from http://nootn.com/blog/Tool/22/
" Version:     2.0
"}}}

" 设置leader为,
let mapleader=","
let g:mapleader=","

set nocompatible            " 关闭 vi 兼容模式
syntax on                   " 自动语法高亮
filetype plugin indent on   " 开启插件
set number                  " 显示行号
set nocursorline            " 不突出显示当前行
set shiftwidth=4            " 设定 << 和 >> 命令移动时的宽度为 4
set softtabstop=4           " 使得按退格键时可以一次删掉 4 个空格
set tabstop=4               " 设定 tab 长度为 4
set nobackup                " 覆盖文件时不备份
set autochdir               " 自动切换当前目录为当前文件所在的目录
set backupcopy=yes          " 设置备份时的行为为覆盖
set ignorecase smartcase    " 搜索时忽略大小写，但在有一个或以上大写字母时仍大小写敏感
set nowrapscan              " 禁止在搜索到文件两端时重新搜索
set incsearch               " 输入搜索内容时就显示搜索结果
set hlsearch                " 搜索时高亮显示被找到的文本
set noerrorbells            " 关闭错误信息响铃
set novisualbell            " 关闭使用可视响铃代替呼叫
set t_vb=                   " 置空错误铃声的终端代码
" set showmatch               " 插入括号时，短暂地跳转到匹配的对应括号
" set matchtime=2             " 短暂跳转到匹配括号的时间
"set nowrap                  " 不自动换行
set magic                  " 显示括号配对情况
set hidden                  " 允许在有未保存的修改时切换缓冲区，此时的修改由 vim 负责保存
set smartindent             " 开启新行时使用智能自动缩进
set backspace=indent,eol,start
                            " 不设定在插入状态无法用退格键和 Delete 键删除回车符
set cmdheight=1             " 设定命令行的行数为 1
set laststatus=2            " 显示状态栏 (默认值为 1, 无法显示状态栏)
set foldenable              " 开始折叠
set foldmethod=syntax       " 设置语法折叠
set foldcolumn=0            " 设置折叠区域的宽度
setlocal foldlevel=1        " 设置折叠层数为
" set foldclose=all           " 设置为自动关闭折叠
" colorscheme colorzone       " 设定配色方案
colorscheme molokai         " 设定配色方案
set statusline=\ %<%F[%1*%M%*%n%R%H]%=\ %y\ %0(%{&fileformat}\ [%{(&fenc==\"\"?&enc:&fenc).(&bomb?\",BOM\":\"\")}]\ %c:%l/%L%)\
                            " 设置在状态行显示的信息
" 显示Tab符
set listchars=tab:\|\ ,trail:.,extends:>,precedes:<
set list


"设置代码折叠方式为 手工  indent
set foldmethod=indent
"设置代码块折叠后显示的行数
set foldexpr=1

if has("gui_running")
    set guioptions-=m " 隐藏菜单栏
    set guioptions-=T " 隐藏工具栏
    set guioptions-=L " 隐藏左侧滚动条
    set guioptions-=r " 隐藏右侧滚动条
    set guioptions-=b " 隐藏底部滚动条
    set showtabline=0 " 隐藏Tab栏
endif

"编辑vim配置文件
if has('unix')
    set fileformats=unix,dos,mac
    nmap <Leader>e :tabnew $HOME/.vimrc<CR>
    let $VIMFILES = $HOME.'/.vim'
else
    set fileformats=dos,unix,mac
    nmap <Leader>e :tabnew $VIM/_vimrc<CR>
    let $VIMFILES = $VIM.'/vimfiles'
endif

" Alt-Space is System menu
if has("gui")
  noremap <M-Space> :simalt ~<CR>
  inoremap <M-Space> <C-O>:simalt ~<CR>
  cnoremap <M-Space> <C-C>:simalt ~<CR>
endif

" 设定doc文档目录
let helptags=$VIMFILES.'/doc'
set helplang=cn
"set nobomb

" {{{ 编码字体设置
set termencoding=chinese
set fileencodings=ucs-bom,utf-8,default,chinese,big5
set ambiwidth=double
set guifont=YaHei\ Consolas\ Hybrid:h12
" }}}

" {{{全文搜索选中的文字
:vmap <silent> <leader>f y/<C-R>=escape(@", '\\/.*$^~[]')<CR><CR>
:vmap <silent> <leader>F y?<C-R>=escape(@", '\\/.*$^~[]')<CR><CR>
" }}}

" 删除所有行未尾空格
nmap <F12> :%s/[ \t\r]\+$//g<CR>

" Buffers操作快捷方式!
nmap <S-L> :bnext<CR>
nmap <S-H> :bprevious<CR>

" Tab操作快捷方式!
nmap <S-J> :tabnext<CR>
nmap <S-K> :tabprev<CR>

" 插入模式下左右移动光标
imap <c-l> <esc>la
imap <c-h> <esc>ha

"窗口分割时,进行切换的按键热键需要连接两次,比如从下方窗口移动
"光标到上方窗口,需要<c-w><c-w>k,非常麻烦,现在重映射为<c-k>,切换的
"时候会变得非常方便.
nmap <C-h> <C-w>h
nmap <C-j> <C-w>j
nmap <C-k> <C-w>k
nmap <C-l> <C-w>l

" 选中状态下 Ctrl+c 复制
vmap <C-c> "+y

" win下的全屏组件，需gvimfullscreen.dll的支持
if !has('unix')
    function! ToggleFullScreen()
        let s:IsFullScreen=libcallnr("gvimfullscreen.dll", "ToggleFullScreen", 27 + 29*256 + 30*256*256)
    endfunction
    map <F11> <Esc>:call ToggleFullScreen()<CR>
endif

"一些不错的映射转换语法（如果在一个文件中混合了不同语言时有用）
nmap <leader>1 :set filetype=xhtml<CR>
nmap <leader>2 :set filetype=css<CR>
nmap <leader>3 :set filetype=javascript<CR>
nmap <leader>4 :set filetype=php<CR>

" Python 文件的一般设置，比如不要 tab 等
"autocmd FileType python set tabstop=4 shiftwidth=4 expandtab

" 设置字典 ~/.vim/dict/文件的路径
autocmd filetype javascript set dictionary=$VIMFILES/dict/javascript.dict
autocmd filetype css set dictionary=$VIMFILES/dict/css.dict
autocmd filetype php set dictionary=$VIMFILES/dict/php.dict


" {{{ plugin - vimExplorer.vim 文件管理器
" :VE 打开文件管理器       tab: 在树、列表窗口切换
" Enter: 树窗口开关目录    u: 列表中在预览窗口打开文件
" ;r 打开Renamer插件
let g:VEConf_systemEncoding='cp936'
"}}}


" {{{ plugin - renamer.vim 文件重命名
" :Renamer 将当前文件所在文件夹下的内容显示在一个新窗口
" :Ren 开始重命名
"}}}


" {{{ plugin - bufexplorer.vim Buffers切换
" \be 全屏方式查看全部打开的文件列表
" \bv 左右方式查看   \bs 上下方式查看
"}}}


" {{{ plugin - bookmarking.vim 设置标记（标签）
" <F9> 设置标记    <F4> 向下跳转标记   <S-F4> 向上跳转标记
"map <F3>   :ToggleBookmark<CR>
"map <F4>   :NextBookmark<CR>
"map <S-F4> :PreviousBookmark<CR>
"}}}


" {{{ plugin - matchit.vim 对%命令进行扩展使得能在嵌套标签和语句之间跳转
" % 正向匹配      g% 反向匹配
" [% 定位块首     ]% 定位块尾
"}}}


" {{{ plugin - mark.vim 给各种tags标记不同的颜色，便于观看调式的插件。
" 这样，当我输入“,hl”时，就会把光标下的单词高亮，在此单词上按“,hh”会清除该单词的高亮。如果在高亮单词外输入“,hh”，会清除所有的高亮。
" 你也可以使用virsual模式选中一段文本，然后按“,hl”，会高亮你所选中的文本；或者你可以用“,hr”来输入一个正则表达式，这会高亮所有符合这个正则表达式的文本。
nmap <silent> <leader>hl <Plug>MarkSet
nmap <silent> <leader>hh <Plug>MarkClear
nmap <silent> <leader>hr <Plug>MarkRegex
vmap <silent> <leader>hl <Plug>MarkSet
vmap <silent> <leader>hh <Plug>MarkClear
vmap <silent> <leader>hr <Plug>MarkRegex
" 你可以在高亮文本上使用“,#”或“,*”来上下搜索高亮文本。在使用了“,#”或“,*”后，就可以直接输入“#”或“*”来继续查找该高亮文本，直到你又用“#”或“*”查找了其它文本。
" <silent>* 当前MarkWord的下一个     <silent># 当前MarkWord的上一个
" <silent>/ 所有MarkWords的下一个    <silent>? 所有MarkWords的上一个
"}}}


" {{{ plugin – winmove.vim 窗口移动
let g:wm_move_left  = "<A-h>"
let g:wm_move_right = "<A-l>"
let g:wm_move_up    = "<A-k>"
let g:wm_move_down  = "<A-j>"
"}}}


" {{{ plugin – ZenCoding.vim 很酷的插件，HTML



Cygwin中文乱码 vim语法高亮 ls颜色显示
2008-11-28 22:05
打开cygwin作如下配置

1 在任何位置执行 vi ~/.bashrc 并在行尾添加如下内容并保存关闭
export LESSCHARSET=latin1
alias less='/bin/less -r'
alias ls='/bin/ls -F --color=tty --show-control-chars'
export LC_ALL=zh_CN.GBK
export LC_CTYPE=zh_CN.GBK
export LANG=zh_CN.GBK
export OUTPUT_CHARSET="GBK"
2 在任何位置执行 vi ~/.inputrc 并在行尾添加如下内容并保存关闭
set meta-flag on
set input-meta on
set convert-meta off
set output-meta on
set completion-ignore-case on

或找到相应配置把前边的注释去掉

3 在任何位置执行 vi ~/.vimrc 添加如下内容并保存关闭（.vimrc文件可能不存在）此配置开启vim语法高亮

syntax on

4 如果是域用户，需要导入域的用户组和用户（我做操作时用户已登录域）。

mkgroup -d >> /etc/group
mkpasswd -d -u 要导入的域用户名 >> /etc/passwd
