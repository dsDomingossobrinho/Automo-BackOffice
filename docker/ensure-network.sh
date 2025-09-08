#!/bin/bash
# Script to ensure network connectivity to backend

echo "🔗 Ensuring network connectivity..."

# Check if we can resolve automo-app
if ! nslookup automo-app >/dev/null 2>&1; then
    echo "❌ Cannot resolve automo-app hostname"
    echo "🔧 Network connectivity issue detected"
    exit 1
fi

echo "✅ Network connectivity OK"

# Test actual connection to backend
if curl -s --connect-timeout 5 http://automo-app:8080/health >/dev/null 2>&1; then
    echo "✅ Backend connection successful"
else
    echo "⚠️ Backend connection failed, but hostname resolves"
fi