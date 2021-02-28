<?php

namespace App\Services;

class DetailedSearch
{
  public static function DetailedSearch($query, $keyword, $request)
  {
    // values
    $order = $request->input('order');
    $lgtm_min = $request->input('lgtm-min');
    $lgtm_max = $request->input('lgtm-max');
    $period = $request->input('period');
    $period_start = $request->input('period-start');
    $period_end = $request->input('period-end');

    //settion
    $request->session()->put('order', $request->input('order'));
    $request->session()->put('lgtm-min', $request->input('lgtm-min'));
    $request->session()->put('lgtm-max', $request->input('lgtm-max'));
    $request->session()->put('period', $request->input('period'));
    if ($request->input('period') == "period") {
      $request->session()->put('period-start', $request->input('period-start'));
      $request->session()->put('period-end', $request->input('period-end'));
    } else {
      $request->session()->forget(['period-start', 'period-end']);
    }

    /* keywordの生成
    */

    /* 全角スペースを半角スペースに変換 */
    $keyword_space_half = mb_convert_kana($keyword, 's');

    /* 半角スペースでsplitし、配列を生成 */
    $keywords = preg_split('/[\s]+/', $keyword_space_half);

    /* "#"を先頭に持つキーワードのみを選定 */
    preg_match_all('/#([a-zA-z0-9０-９ぁ-んァ-ヶ亜-熙]+)/u', $keyword, $match);

    /* 検索キーワードに"#"がつくものを除外 */
    $no_tag_keywords = array_diff($keywords, $match[0]);

    /* #を除外したタグキーワード */
    $tags = $match[1];

    //LGTM sum search
    $query
      ->join('likes_counts', 'posts.id', '=', 'likes_counts.post_id');
    if ($lgtm_min !== null) {
      $query->where('likes_count', '>=', $lgtm_min);
    }
    if ($lgtm_max !== null) {
      $query->where('likes_count', '<=', $lgtm_max);
    }

    // period search
    if ($period !== null) {
      switch ($period) {
        case "day":
          $query->where('posts.created_at', '>=', date("Y-m-d 00:00:00"));
          $query->where('posts.created_at', '<=', date("Y-m-d H:i:s"));
        case "week":
          $query->where('posts.created_at', '>=', date("Y-m-d 00:00:00", strtotime("-1 week")));
          $query->where('posts.created_at', '<=', date("Y-m-d H:i:s"));
        case "month":
          $query->where('posts.created_at', '>=', date("Y-m-d 00:00:00", strtotime("-1 month")));
          $query->where('posts.created_at', '<=', date("Y-m-d H:i:s"));
        case "period":
          if ($period_start !== null) {
            $query->where('posts.created_at', '>=', date("{$period_start} 00:00:00"));
          }
          if ($period_end !== null) {
            $query->where('posts.created_at', '<=', date("{$period_end} 23:59:59"));
          }
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
      $query->orderBy('posts.created_at', 'desc');
    } else {
      $query->orderBy('likes_count', 'desc');
    }

    // 配列を取得
    $posts = $query->paginate(20);
    return $posts;
  }
}
