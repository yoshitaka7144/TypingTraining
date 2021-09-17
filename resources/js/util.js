export const OK = 200;
export const CREATED = 201;
export const UNPROCESSABLE_ENTITY = 422;
export const INTERNAL_SERVER_ERROR = 500;

export const DEFAULT_QUESTION_COUNT = 5;

export const END_SYMBOL = "$";

export const LOGIN_NAME_ERROR_REQUIRE = "ユーザー名は必須項目です。";
export const LOGIN_PASSWORD_ERROR_REQUIRE = "パスワードは必須項目です。";

export const REGISTER_NAME_MAX_NUMBER = 15;
export const REGISTER_NAME_ERROR_REQUIRE = "ユーザー名は必須項目です。";
export const REGISTER_NAME_ERROR_LIMIT = "ユーザー名は" + REGISTER_NAME_MAX_NUMBER + "文字以内で入力して下さい。";

export const REGISTER_PASSWORD_MIN_NUMBER = 4;
export const REGISTER_PASSWORD_ERROR_REQUIRE = "パスワードは必須項目です。";
export const REGISTER_PASSWORD_ERROR_LIMIT = "パスワードは半角英数字" + REGISTER_PASSWORD_MIN_NUMBER + "文字以上で入力して下さい。";
export const REGISTER_PASSWORD_CONFIRMATION_ERROR_REQUIRE = "パスワード確認は必須項目です。";
export const REGISTER_PASSWORD_CONFIRMATION_ERROR_INCORRECT = "パスワードと一致しません。";

export const REGISTER_QUESTION_TEXT_MAX_NUMBER = 30;
export const REGISTER_QUESTION_TEXT_ERROR_REQUIRE = "問題は必須項目です。";
export const REGISTER_QUESTION_TEXT_ERROR_LIMIT = "問題は" + REGISTER_QUESTION_TEXT_MAX_NUMBER + "文字以内で入力して下さい。";
export const REGISTER_QUESTION_TEXT_ERROR_PATTERN = "問題は漢字 or カタカナ or ひらがな or 数字 or 記号（ー,.、。）で入力してください";
export const REGISTER_QUESTION_KANA_MAX_NUMBER = 45;
export const REGISTER_QUESTION_KANA_ERROR_REQUIRE = "かなは必須項目です。";
export const REGISTER_QUESTION_KANA_ERROR_LIMIT = "かなは" + REGISTER_QUESTION_KANA_MAX_NUMBER + "文字以内で入力して下さい。";
export const REGISTER_QUESTION_KANA_ERROR_PATTERN = "かなはひらがな or 数字 or 記号（ー,.、。）で入力してください";

export const REGISTER_QUESTION_ROMAN_MAX_NUMBER = 90;
export const REGISTER_QUESTION_ROMAN_ERROR_REQUIRE = "タイピング文字は必須項目です。";
export const REGISTER_QUESTION_ROMAN_ERROR_LIMIT = "タイピング文字は" + REGISTER_QUESTION_ROMAN_MAX_NUMBER + "文字以内で入力して下さい。";
export const REGISTER_QUESTION_ROMAN_ERROR_PATTERN = "タイピング文字は半角数字 or 英小文字 or 記号（-,.）で入力してください";
