#!/usr/bin/env python3
"""
Test Database Connection for ML Microservice
Run this script to verify database connectivity before training models
"""

from app.config import test_db_connection

def main():
    print("🔍 Testing ML Microservice Database Connection")
    print("=" * 50)

    if test_db_connection():
        print("\n✅ All database checks passed!")
        print("You can now run: python train_models.py")
        return

    print("\n❌ Database connection failed!")
    print("\n🔧 Troubleshooting:")
    print("1. Ensure MySQL is running (Laragon -> Services -> MySQL)")
    print("2. Check database name in app/config.py (should be 'ai_marketer_pro')")
    print("3. Check MySQL credentials (default: root, no password)")
    print("4. Verify campaign_analytics table exists: php artisan migrate")
    print("\nRun this script again after fixing the issues.")
    exit(1)

if __name__ == "__main__":
    main()
