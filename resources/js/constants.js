// URL PATH
export const PREFIX_ADMIN = '/manage';
export const  MESSAGES_ROOT_PATH = '/messages';
export const SEARCH_MESSAGES_PATH = (room_id, searchString) => `${MESSAGES_ROOT_PATH}/${room_id}/search?text=${searchString}`;

// Error Messages
export const ERROR_CONNECTION_PROBLEM = 'Something went wrong! Try to reload this page.';
export const ERROR_MESSAGES_NOT_FOUND = 'No messages found';
export const ERROR_NO_HISTORY = 'No messages yet, start the conversation!';