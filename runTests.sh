#!/bin/sh

# Run the tests from ./tests
#
# You can run all the test (that are not excluded)
#   ./runTests.sh .
# or a subset (often by directory)
#   ./runTests.sh basics/

clear
date

TEST="$@"
if [ -z "$TEST" ]; then
    # no tests given, go test the biggest set
    TEST="./tests/"
fi

VERBOSE="--verbose  --testdox "   # --debug
COVERAGE="--coverage-html=build/coverage"
COLORS="--colors"
# config run by default, includes bootstrap
CONF=" -d memory_limit=1024M"
#GROUPEXCLUDE=" --exclude-group done"    # don't run these groups

# Use the phpunit.phar brought in by Composer
PHPUNIT="php -f phpunit.phar -- "

time \
  $PHPUNIT $CONF $GROUP $GROUPEXCLUDE $COLORS $VERBOSE $MORE $MORE2 $COVERAGE $TEST

# http://stackoverflow.com/questions/911168/how-to-detect-if-my-shell-script-is-running-through-a-pipe
if [ -t 1 ] ; then
    # we are running in a TTY - under human control. Allow easy running again
    echo "#$PHPUNIT $GROUP $COLORS $VERBOSE $CONF $MORE $COVERAGE $TEST"
    echo ""
    echo ""
    echo -n "press [Enter] to re-run:> "
    read x
    #cd ..

    exec $0 $@
fi
