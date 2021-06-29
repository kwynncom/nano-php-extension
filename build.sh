ODIR=`pwd`
BDIR=/tmp/npk
if [ ! -d $BDIR ]; then
    mkdir $BDIR
fi
cp * $BDIR
cd $BDIR
phpize
./configure --enable-nanopk
make
php -d extension=$BDIR/modules/nanopk.so $ODIR/test.php
