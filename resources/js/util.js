//apiステータス：成功
export const OK = 200;
//apiステータス：データ作成
export const CREATED = 201;
//apiステータス：UNPROCESSABLE
export const UNPROCESSABLE_ENTITY = 422;
//apiステータス：システムエラー
export const INTERNAL_SERVER_ERROR = 500;

// 問題数設定初期値
export const DEFAULT_QUESTION_COUNT = 5;
// 問題テキスト制御用文字
export const END_SYMBOL = "$";

// ログイン：ユーザー名必須エラー
export const LOGIN_NAME_ERROR_REQUIRE = "ユーザー名は必須項目です。";
// ログイン：パスワード必須エラー
export const LOGIN_PASSWORD_ERROR_REQUIRE = "パスワードは必須項目です。";

// ユーザー作成：ユーザー名最大文字数
export const REGISTER_NAME_MAX_NUMBER = 15;
// ユーザー作成：ユーザー名必須エラー
export const REGISTER_NAME_ERROR_REQUIRE = "ユーザー名は必須項目です。";
// ユーザー作成：ユーザー文字数エラー
export const REGISTER_NAME_ERROR_LIMIT = "ユーザー名は" + REGISTER_NAME_MAX_NUMBER + "文字以内で入力して下さい。";
// ユーザー作成：パスワード最小文字数
export const REGISTER_PASSWORD_MIN_NUMBER = 4;
// ユーザー作成：パスワード必須エラー
export const REGISTER_PASSWORD_ERROR_REQUIRE = "パスワードは必須項目です。";
// ユーザー作成：パスワード文字数エラー
export const REGISTER_PASSWORD_ERROR_LIMIT = "パスワードは半角英数字" + REGISTER_PASSWORD_MIN_NUMBER + "文字以上で入力して下さい。";
// ユーザー作成：パスワード確認必須エラー
export const REGISTER_PASSWORD_CONFIRMATION_ERROR_REQUIRE = "パスワード確認は必須項目です。";
// ユーザー作成：パスワード確認不一致エラー
export const REGISTER_PASSWORD_CONFIRMATION_ERROR_INCORRECT = "パスワードと一致しません。";

// 問題登録：問題テキスト最大文字数数
export const REGISTER_QUESTION_TEXT_MAX_NUMBER = 30;
// 問題登録：問題テキスト必須エラー
export const REGISTER_QUESTION_TEXT_ERROR_REQUIRE = "問題は必須項目です。";
// 問題登録：問題テキスト文字数エラー
export const REGISTER_QUESTION_TEXT_ERROR_LIMIT = "問題は" + REGISTER_QUESTION_TEXT_MAX_NUMBER + "文字以内で入力して下さい。";
// 問題登録：問題テキストパターンエラー
export const REGISTER_QUESTION_TEXT_ERROR_PATTERN = "問題は漢字 or カタカナ or ひらがな or 数字 or 記号（ー,.、。）で入力してください";
// 問題登録：かなテキスト最大文字数数
export const REGISTER_QUESTION_KANA_MAX_NUMBER = 45;
// 問題登録：かなテキスト必須エラー
export const REGISTER_QUESTION_KANA_ERROR_REQUIRE = "かなは必須項目です。";
// 問題登録：かなテキスト文字数エラー
export const REGISTER_QUESTION_KANA_ERROR_LIMIT = "かなは" + REGISTER_QUESTION_KANA_MAX_NUMBER + "文字以内で入力して下さい。";
// 問題登録：かなテキストパターンエラー
export const REGISTER_QUESTION_KANA_ERROR_PATTERN = "かなはひらがな or 数字 or 記号（ー,.、。）で入力してください";
// 問題登録：タイピング文字テキスト最大文字数数
export const REGISTER_QUESTION_ROMAN_MAX_NUMBER = 90;
// 問題登録：タイピング文字テキスト必須エラー
export const REGISTER_QUESTION_ROMAN_ERROR_REQUIRE = "タイピング文字は必須項目です。";
// 問題登録：タイピング文字テキスト文字数エラー
export const REGISTER_QUESTION_ROMAN_ERROR_LIMIT = "タイピング文字は" + REGISTER_QUESTION_ROMAN_MAX_NUMBER + "文字以内で入力して下さい。";
// 問題登録：タイピング文字テキストパターンエラー
export const REGISTER_QUESTION_ROMAN_ERROR_PATTERN = "タイピング文字は半角数字 or 英小文字 or 記号（-,.）で入力してください";
