PHP_ARG_ENABLE(nanopk, Whether to enable the nanopkPHP extension, [ --enable-nanopk Enable nanopkPHP])

if test "$NANOPK" != "no"; then
    PHP_NEW_EXTENSION(nanopk, nanopk.c, $ext_shared)
fi
