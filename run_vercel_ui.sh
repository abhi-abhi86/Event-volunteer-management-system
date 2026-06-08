#!/usr/bin/env bash
set -euo pipefail

# This file is informational only.
# Vercel hosts the static UI (index.html/events.html/register.html/admin_login.html).
# For backend (PHP/MySQL) you must convert to a serverless backend.

echo "Vercel deployment:"
echo "  1) Connect GitHub repo to Vercel"
echo "  2) Build/Framework: Static site (or no build)"
echo "  3) Output: project root"
echo "  4) Vercel will serve index.html via vercel.json rewrites"

