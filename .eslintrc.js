module.exports =  {
  env: {
  	browser: true,
  	jquery: true,
  	es6: true
  },
  extends:  [
    'wordpress',
    'plugin:prettier/recommended',  // Enables eslint-plugin-prettier and displays prettier errors as ESLint errors. Make sure this is always the last configuration in the extends array.
  ],
  rules:  {},
};
