![oiita](https://user-images.githubusercontent.com/52862370/96419448-1f21be00-122f-11eb-983f-febc58f61fc2.png)

# Introduction
Oiitaは「Qiita」に影響を受けたプロジェクトです。一番の違いは、オリジナルの絞り込み検索です。
Qiitaはキーワードでの検索が可能でありながら、複数タグでの検索やLGTM数、期間指定などができません。そのため、目的の記事が見つけにくい問題があります。そこでOiitaでは、絞り込み検索の充実させ、目的としている記事をみつけやすいように改善しました。

Oiita will be a project inspired by "Qiita". The biggest difference is the ability to refine the search.
While Qiita allows you to search by keywords, it does not allow you to search by multiple tags, number of LGTMs, or time period. So it can be difficult to find the articles you are looking for. So, we have improved the search function in Oiita to make it easier to find the articles you are looking for.
<br>
<br>

## URL
- URL: http://oiita.site/
- ユーザー: ゲストログインボタンを押しと簡単にログインできます。


## Purpose

- 絞り込み検索を実装して、目的の記事を見つけやすくする。
- 実践を通して、SQLの理解を深める
<br>
<br>

- Implement a narrowed search to make it easier to find the article you want.
- Deepen your understanding of SQL through practice
<br>
<br>
<br>

## ER図 ER Diagram

![ER図](https://user-images.githubusercontent.com/52862370/96422391-ec79c480-1232-11eb-9c29-201200699e9a.png)<br>
<br>
<br>
今回の目的はSQLを利用した絞り込み検索の実装なので、シンプルな構造となっている。

## Environment

- 言語: PHP 7.3.18
- フレームワーク: Laravel 6.18.40
- WEBサーバー: Apache
- DB:　MySQL 5.6.47
- AWS（EC2, RDS）
- jQuery

# function

ここではOiitaの機能紹介をしていきます。<br>
<br>
- 記事一覧の表示
- キーワード検索機能（header)
    - 複数キーワード検索
    - 複数タグ検索
- 絞り込み検索(side)
    - 複数キーワード検索
    - 複数タグ検索
    - 順番（新規投稿順、LGTM数順）
    - 投稿期間の指定（本日、１週間、1ヶ月間、期間指定）
    - LGTM数の指定（最低数、最高数）
    - 記事全体で検索、LGTMした記事で検索
- 記事投稿
    - 新規作成(Markdown記法)
    - 編集
    - 削除
- いいね機能（Ajax） like button
- User認証
    - 新規登録
    - ログイン




I will introduce the features of Oiita here.<br>
<br>

- list of articles
- Keyword search in header
    - Multiple keyword search
    - Multiple Tag Search
- conditional search
    - Multiple keyword search
    - Multiple Tag Search
    - Order (in order of new submissions or sum of LGTMs)
    - period specified (today, week, month, start to end date)
    - Specify the range of the number of LGMTs( min and max )
    - Search the entire article or search by LGTMed article
- Article Submission
    - Create New (Markdown)
    - Edit
    - Delete
- like button
- User auth
<br>
<br>
<br>


## 記事一覧の表示（list of articles）

![Oiita記事一覧](https://user-images.githubusercontent.com/52862370/96441062-d7f1f800-1243-11eb-8616-859b6e1e6226.gif)
<br>
<br>
<br>
「すべて」を選択した場合はすべての記事が表示され、「LGTM済み」を選択した場合はLGTM（いいね）した記事のみ一覧表示される。ただし、LGTMするにはログインする必要がある。影響を受けた「Qiita」では「LGTM」と「ストック」の二つの機能に別れているが、別々にする必要性がないため「Oiita」では「LGTM」のみとなっている。また、後述する検索機能を活用すれば、検索結果を絞り込むことができる。<br>
If you select "すべて", all the articles are shown, and if you select "LGTM済み", only the articles you "LGTMed" (liked) are shown. However, you need to be logged in to LGTM. In the affected "Qiita" it is split into two functions, "LGTM" and "Stock", but in "Oiita" it is only "LGTM" as there is no need to separate them. In addition, the search function, described below, can be used to narrow down the search results.
<br>
<br>
<br>


## キーワード検索機能（header) Keyword search(header)

![複数キーワード検索](https://user-images.githubusercontent.com/52862370/96458276-b1d85200-125b-11eb-8908-724dca1c7b3a.gif)
<br>
<br>
headerにある検索フォームでは、複数のキーワードとタグで検索結果の絞り込みが可能。<br>
The search form in the header allows you to narrow down your search results with multiple keywords and tags.
<br>
<br>


### 複数キーワード検索（Multiple keyword search）

![複数タグ検索](https://user-images.githubusercontent.com/52862370/96445521-01625200-124b-11eb-8363-a8a1ec965a7e.gif)

<br>
複数のキーワードで絞り込みするには、キーワードとキーワードの間をスペース（半角、全角とも可能）で区切る必要がある。記事のタイトルか内容に指定したキーワードが含まれている場合、検索結果に表示される。
<br>
To narrow down the search by multiple keywords, you need to separate the keywords with a space (both one-byte and two-byte characters are possible). If the keyword is included in the title or content of the article, it will be displayed in the search results.
<br>
<br>


### 複数タグ（Multiple Tag Search）

![Oiita複数タグ](https://user-images.githubusercontent.com/52862370/96443753-0ffb3a00-1248-11eb-807d-9e45068c67af.gif)
<br>キーワードだけではなくタグで絞り込みたい場合は、タグ名の先頭に`#`を付与して検索する。
If you want to search not only by keywords but also by tags, put `#` at the beginning of the tag name.
<br>
<br>
<br>


## 絞り込み検索(side) conditional search

サイドカラムにある絞り込み検索フォームでは、複数のキーワードとタグの他に条件を指定して検索することが可能。<br>
The narrowed search form in the side column allows you to specify multiple keywords and tags as well as criteria for searching.<br>
![oiita2](https://user-images.githubusercontent.com/52862370/96419552-44163100-122f-11eb-9a81-33e7fe507a39.png)<br>
<br>
<br>
Laravelのクエリビルダを利用しており、全体の記述は下記になる。

```php
public function index(Request $request)
    {
        // values
        $tag_btn_value = $request->input('tag_btn');
        $order = $request->input('order');
        $lgtm_min = $request->input('lgtm-min');
        $lgtm_max = $request->input('lgtm-max');
        $period = $request->input('period');
        $period_start = $request->input('period-start');
        $period_end = $request->input('period-end');


        // keyword
        $keyword = $request->input('search');
        $keyword_space_half = mb_convert_kana($keyword, 's');
        $keywords = preg_split('/[\s]+/', $keyword_space_half);
        preg_match_all('/#([a-zA-z0-9０-９ぁ-んァ-ヶ亜-熙]+)/u', $keyword, $match);
        $no_tag_keywords = array_diff($keywords, $match[0]);
        $tags = $match[1];
        $tags_count = count($tags);

        // query
        $query = Post::withCount('likes');

        //LGTM sum search
        if ($lgtm_min !== null) {
            $query->having('likes_count', '>=', $lgtm_min);
        }
        if ($lgtm_max !== null) {
            $query->having('likes_count', '>=', $lgtm_max);
        }

        // period search
        if ($period !== null) {
            switch ($period) {
                case "day":
                    $query->where([
                        ['posts.created_at', '>=', date("Y-m-d 00:00:00")],
                        ['posts.created_at', '<=', date("Y-m-d 23:59:59")]
                    ]);
                case "week":
                    $query->where([
                        ['posts.created_at', '>=', date("Y-m-d 00:00:00", strtotime("-1 week"))],
                        ['posts.created_at', '<=', date("Y-m-d 23:59:59")]
                    ]);
                case "month":
                    $query->where([
                        ['posts.created_at', '>=', date("Y-m-d 00:00:00", strtotime("-1 month"))],
                        ['posts.created_at', '<=', date("Y-m-d 23:59:59")]
                    ]);
                case "period":
                    $query->where([
                        ['posts.created_at', '>=', date("{$period_start} 00:00:00")],
                        ['posts.created_at', '<=', date("{$period_end} 23:59:59")]
                    ]);
            }
        }

        if ($keyword !== null) {
            // tags search
            if (count($tags) !== 0) {
                $query
                    ->join('post_tags', 'posts.id', '=', 'post_tags.post_id')
                    ->join('tags', 'post_tags.tag_id', '=', 'tags.id')
                    ->whereIn('tags.name', $tags)
                    ->groupBy('posts.id')
                    ->havingRaw('count(distinct tags.id) = ?', [count($tags)]);
            }

            // keywords search
            foreach ($no_tag_keywords as $no_tag_keyword) {
                $query
                    ->where(function ($query) use ($no_tag_keyword) {
                        $query
                            ->where('posts.title', 'like', '%' . $no_tag_keyword . '%')
                            ->orWhere('posts.body', 'LIKE', "%{$no_tag_keyword}%");
                    });
            }
        }


        // search order
        if ($order == 'new') {
            $posts = $query->orderBy('posts.created_at', 'desc')->get();
        } else {
            $posts = $query->orderBy('likes_count', 'desc')->get();
        }

        return view('posts.index', compact('posts', 'keyword', 'tag_btn_value'));
    }
````

これだとfat controllerのため、DetailedSearch.phpにコントローラー処理を分離して、下記の記述に短縮させた。

```
public function index(Request $request)
    {
        // values
        $tag_btn_value = $request->input('tag_btn');
        $order = $request->input('order');
        $lgtm_min = $request->input('lgtm-min');
        $lgtm_max = $request->input('lgtm-max');
        $period = $request->input('period');
        $period_start = $request->input('period-start');
        $period_end = $request->input('period-end');
        $all_posts_count = DB::table('posts')->count();

        // keyword
        $keyword = $request->input('search');
        if ($tag_btn_value !== null) {
            $keyword = "#{$tag_btn_value}";
        }

        // query
        $query = Post::withCount('likes');
        $posts = DetailedSearch::DetailedSearch($query, $lgtm_min, $lgtm_max, $period, $period_start, $period_end, $keyword, $order);
        return view('posts.index', compact('all_posts_count', 'posts', 'keyword', 'order', 'lgtm_min', 'lgtm_max', 'period', 'period_start', 'period_end', 'tag_btn_value'));
    }
```


### 複数キーワード検索

![絞り込み検索（キーワード&タグ）](https://user-images.githubusercontent.com/52862370/96460982-ca963700-125e-11eb-9750-a5a863299551.png)<br>
<br>
<br>
headerの検索フォームと同じく複数キーワードで条件を絞ることが可能。エンターを押すことで検索が実行される<br>
<br>

#### コード

foreachでwhere文を繰り返し、検索キーワードの条件に当てはまる記事に絞り込む

```php
            foreach ($no_tag_keywords as $no_tag_keyword) {
                $query
                    ->where(function ($query) use ($no_tag_keyword) {
                        $query
                            ->where('posts.title', 'like', '%' . $no_tag_keyword . '%')
                            ->orWhere('posts.body', 'LIKE', "%{$no_tag_keyword}%");
                    });
            }
```
<br>
<br>

### 複数タグ検索

![絞り込み検索（複数タグ）](https://user-images.githubusercontent.com/52862370/96461225-15b04a00-125f-11eb-912b-777f0b4f93ef.png)<br>
<br>
headerの検索フォームと同じく、タグ名の先頭に`#`を付与することで、そのタグを保有する記事に絞ることができる。複数のタグで絞り込み可能。キーワードとタグを合わせることで記事をより絞り込むことができます。<br>
<br>

#### コード

クエリビルダでtagモデルとその中間テーブルを結合し、havingで記事に紐づくタグ数が検索フォームで入力したタグ数と一致している、かつwhereInで検索したタグ名を含む記事を取得している。

```php
$query = Post::withCount('likes');

if (count($tags) !== 0) {
    $query
        ->join('post_tags', 'posts.id', '=', 'post_tags.post_id')
        ->join('tags', 'post_tags.tag_id', '=', 'tags.id')
        ->whereIn('tags.name', $tags)
        ->groupBy('posts.id')
        ->havingRaw('count(distinct tags.id) = ?', [count($tags)]);
}
```
<br>
<br>
<br>

### 順番（新規投稿順、LGTM数順）

![order](https://user-images.githubusercontent.com/52862370/96461360-41333480-125f-11eb-98b5-c5ec1a4d89cb.png)
<br>
<br>
標準ではLGTMが多い記事の順番で表示される（LGTM数順）。しかし、最新の記事を求める場合に備えて新規投稿順に変更することが可能
<br>
<br>
<br>

#### コード
「LGTM数順」のときは、`orderBy('likes_count', 'desc')`になり、「新着順」のときは`orderBy('posts.created_at', 'desc')`となる

```php
$order = $request->input('order');
$query = Post::withCount('likes');

// search order
if ($order == 'new') {
    $posts = $query->orderBy('posts.created_at', 'desc')->get();
} else {
    $posts = $query->orderBy('likes_count', 'desc')->get();
}
```        
<br>
<br>

### 投稿期間の指定
![絞り込み検索（期間指定）](https://user-images.githubusercontent.com/52862370/96461518-7049a600-125f-11eb-8b0b-8e482f2ee37f.png)
<br>
<br>
日付を指定して、その期間に投稿された記事の一覧を取得することが可能。<br>
<br>
<br>
<br>


#### 選択肢
- 本日: 今日の日付に投稿された記事を取得
- 1週間: 直近1週間の間に投稿された記事を取得
- 1ヶ月: 直近1ヶ月間に投稿された記事を取得
- 期間指定: ユーザーが指定した期間に投稿された記事を取得する。
<br>
<br>
<br>

#### コード
記事の投稿日を`posts.created_at`で取得し、date関数を利用して絞り込みを実施している。

```php
        // period search
        if ($period !== null) {
            switch ($period) {
                case "day":
                    $query->where([
                        ['posts.created_at', '>=', date("Y-m-d 00:00:00")],
                        ['posts.created_at', '<=', date("Y-m-d 23:59:59")]
                    ]);
                case "week":
                    $query->where([
                        ['posts.created_at', '>=', date("Y-m-d 00:00:00", strtotime("-1 week"))],
                        ['posts.created_at', '<=', date("Y-m-d 23:59:59")]
                    ]);
                case "month":
                    $query->where([
                        ['posts.created_at', '>=', date("Y-m-d 00:00:00", strtotime("-1 month"))],
                        ['posts.created_at', '<=', date("Y-m-d 23:59:59")]
                    ]);
                case "period":
                    $query->where([
                        ['posts.created_at', '>=', date("{$period_start} 00:00:00")],
                        ['posts.created_at', '<=', date("{$period_end} 23:59:59")]
                    ]);
            }
        }
```
<br>
<br>

### LGTM数の指定


![絞り込み検索（LGTM数）](https://user-images.githubusercontent.com/52862370/96461633-940cec00-125f-11eb-8fa4-931e782778da.png)
<br>
<br>
LGTM数の最低数や最高数を指定して、その範囲内の記事を取得する。これによりLGTM数が多い良質な記事に絞って検索したり、LGMT数が少ない記事の分析をするなど、ユーザーの使う意図に合わせて検索が可能になった。<br>
<br>
<br>
<br>

#### コードについて
SQLのASを利用してLGTMの合計数である`likes_count`を定義。`likes_count`がLGTM数の最低数`$lgtm_min`より数が多く、最高数`$lgtm_max`よりも少ない記事を取得する。<br>
<br>

```php
        // query
        $query = Post::withCount('likes');

        //LGTM sum search
        if ($lgtm_min !== null) {
            $query->having('likes_count', '>=', $lgtm_min);
        }
        if ($lgtm_max !== null) {
            $query->having('likes_count', '<=', $lgtm_max);
        }
```
<br>
<br>
<br>

## 記事投稿 How to Article Submission
Markdown記法で記事の投稿、編集が可能。


### 新規投稿 Create
headerにある「投稿する」ボタンをクリックすると、記事の作成画面に移行する。

![新規作成ボタン](https://user-images.githubusercontent.com/52862370/96473516-b6593680-126c-11eb-88e4-765925c6d100.png)

記事作成時はMarkdownで記述が可能

![Markdown](https://user-images.githubusercontent.com/52862370/96419584-4d070280-122f-11eb-89ae-f5304d2cf3c3.png)

### 編集 Edit
投稿したい記事を編集したい場合、編集ボタンをクリックする。<br>
<br>
![編集ボタン](https://user-images.githubusercontent.com/52862370/96532240-6dce6700-12c6-11eb-80ce-e936187833e9.png)<br>
<br>
<br>

ただしこの編集ボタンは、記事の投稿者のIDとログインしているUseriDが一致していなければ表示されない。<br>
<br>
<br>
<br>

### 削除 Delete
投稿者のUserIDと現在ログインしているUserIDが一致している場合は、記事を削除することができる。<br>
記事を削除するには、まず設定ボタンを押す<br>
![削除の操作1](https://user-images.githubusercontent.com/52862370/96533343-b4bd5c00-12c8-11eb-8789-64e224f6ca2e.png)<br>
<br>
<br>
そうすると削除ボタンが表示され、これをクリックして削除を実行する。
![削除操作2](https://user-images.githubusercontent.com/52862370/96533402-d880a200-12c8-11eb-863e-b272db121f9f.png)<br>
<br>
`$post->exists()`で記事が削除済みか判定し、すでに削除ずみの場合はトップページにリダイレクトされる。<br>

```php
            if ($post->exists()) {
                $user = Auth::user();

                if ($user->id === $post->user_id) {

                    $post->delete();
                    return redirect(route('root'))->with('flash_message', '削除されました');
                } else {
                    return back()->with('flash_message', '投稿者でなければ削除できません');
                }
            } else {
                return redirect(route('root'))->with('flash_message', 'すでに存在しません');
            }
```
<br>
<br>
<br>

## いいね機能（Ajax） like button
<br>

![いいね機能](https://user-images.githubusercontent.com/52862370/96536013-1633f980-12ce-11eb-85f8-e2568afdffc1.gif)

<br>
<br>
LGTM（いいね）ボタンをクリックすると、記事を評価すると同時に、LGTMした記事として保持できる。ボタンの背景が白色から緑色に変化したら、LGTM済みです。<br>
LGTMを取り消したい場合は、再度押すことで取り消すことができる。<br>
ただし、JavaScriptのAjaxを使って非同期処理をしているため、ブラウザでJavaScriptを有効にしておく必要がある。<br>
<br>
<br>
<br>

## User認証
こちらでは簡単にUser認証の使い方を紹介する

### 新規登録
トップページにある、`新規登録`ボタンをクリックすると新規登録画面に移行する。

### ログイン
トップページにある、`ログイン`ボタンをクリックするとログイン画面に移行する。
またトップページにはログインフォームが用意されているため、それを利用してログインすることも可能。

### ログアウト
ログインすると右上にアイコンが表示されるため、それをクリックし`ログアウト`ボタンを押すことでログアウトされる。<br>
<br>
![ログアウト](https://user-images.githubusercontent.com/52862370/96535624-2dbeb280-12cd-11eb-8b99-3a4338cb0ec1.png)<br>
<br>
<br>

