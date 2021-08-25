export const OK = 200;
export const CREATED = 201;
export const UNPROCESSABLE_ENTITY = 422;
export const INTERNAL_SERVER_ERROR = 500;

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