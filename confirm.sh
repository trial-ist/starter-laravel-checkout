#!/usr/bin/env bash
# The acceptance checks Trialist runs when you submit (the "verify" step in trialist.json).
# Trialist restores this script and tests/Acceptance from the starting commit first,
# so editing them doesn't change the result. You can run it yourself: bash confirm.sh
set -uo pipefail
php vendor/bin/phpunit tests/Acceptance --colors=never ${TRIALIST_JUNIT:+--log-junit "$TRIALIST_JUNIT"}
