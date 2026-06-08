#!/usr/bin/env bash
set -euo pipefail

# Opens the project in XAMPP (local PHP)
# Assumes the project is copied into htdocs as: /Event-volunteer-management-system/
# Usage:
#   ./run_local.sh

echo "Run PHP/MySQL locally using XAMPP."
echo "Steps:"
echo "  1) Start Apache + MySQL in XAMPP."
echo "  2) Import database.sql into MySQL (create volunteer_management)."
echo "  3) Open: http://localhost/Event-volunteer-management-system/index.php"

open "http://localhost/Event-volunteer-management-system/index.php"

