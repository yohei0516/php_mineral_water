    /**
     * [関数名] chkMinLength
     * [機　能] 入力文字数チェック
     * [説　明] 文字列の文字数を調べ、最大文字数以内で入力されているか調べる
     *　　　　　半角、全角、改行（\n）は1文字としてカウントされる
     * [引　数]
     * @param obj フォームオブジェクト
     * @param strLength 最大文字数
     * [返り値]
     * @return なし
    */
    function chkMinLength(obj, strLength) {
        var tmpLength=obj.value.length;//入力された文字列の長さ（文字数）
        if(tmpLength < strLength) {
            /* 入力文字数が最大文字数を超えている場合 */
            alert(tmpLength+"文字 &gt; 最小"+strLength+"文字\n\nパスワードは最小8文字以上入力してください");
        }else{
            /* 入力文字数が最小文字数に満たない場合 */
            alert(tmpLength+"文字 &gt; 最小"+strLength+"文字\n\nパスワードは正確に入力されました");
        }
    }

    /**
     * [関数名] chkRegEmail
     * [機　能] 正規表現によるメールアドレス（E-mail）チェック
     * [引　数]
     * @param str 入力された文字列
     * [返り値]
     * @return true(E-mail形式である場合) | false(E-mail形式でない場合)
    */
    function chkRegEmail(str){
        /* E-mail形式の正規表現パターン */
        /* @が含まれていて、最後が .(ドット)でないなら正しいとする */
          var Seiki=/[!#-9A-~]+@+[a-z0-9]+.+[^.]$/i;
        /* 入力された値がパターンにマッチするか調べる */
        if(str!=""){
            if(str.match(Seiki)){
                // alert(str.match(Seiki)+"\n\nメールアドレスの形式は正しいです");
                return true;
        }else{
                alert("メールアドレスの形式が不正です");
                return false;
            }
        }else{
            /* 何も入力されていない場合はアラート表示 */
            alert("メールアドレスを入力してください");
            return false;
        }
    }

    function chkNickName(str){
          var str;
        /* 入力された値の空チェック */
        if(str!=""){
                return true;
        }else{
            /* 何も入力されていない場合はアラート表示 */
            alert("ニックネームを入力してください");
            return false;
        }
    }

function checkForm(){
    if(document.form1.input01.value == "" || document.form1.input02.value == ""){
        alert("必須項目を入力して下さい。");
    return false;
    }else{
    return true;
    }
}