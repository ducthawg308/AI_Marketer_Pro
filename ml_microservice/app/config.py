# Hardcoded MySQL configuration for MySQL connection (if needed)
# Do not touch Laravel .env file

MYSQL_CONFIG = {
    "host": "localhost",  # Adjust if different
    "user": "root",       # Default Laragon MySQL user
    "password": "",       # No password by default in Laragon; set if configured
    "database": "ai_marketer_pro"  # Database name
}

# Database connection function
def get_db_connection():
    """Create and return MySQL database connection"""
    import pymysql

    try:
        connection = pymysql.connect(
            host=MYSQL_CONFIG["host"],
            user=MYSQL_CONFIG["user"],
            password=MYSQL_CONFIG["password"],
            database=MYSQL_CONFIG["database"],
            charset='utf8mb4',
            cursorclass=pymysql.cursors.DictCursor
        )

        # Test connection by running a simple query
        with connection.cursor() as cursor:
            cursor.execute("SELECT DATABASE() as current_db")
            result = cursor.fetchone()
            print(f"✅ Connected to database: {result['current_db']}")

        return connection
    except pymysql.Error as e:
        print(f"❌ Database connection error: {e}")
        print("💡 Check: Is MySQL running? Is the database name correct?")
        print(f"💡 Config: host={MYSQL_CONFIG['host']}, user={MYSQL_CONFIG['user']}, db={MYSQL_CONFIG['database']}")
        return None

def test_db_connection():
    """Test database connection and show table info"""
    connection = get_db_connection()
    if not connection:
        return False

    try:
        with connection.cursor() as cursor:
            # Check if table exists
            cursor.execute("SHOW TABLES LIKE 'campaign_analytics'")
            if not cursor.fetchone():
                print("❌ Table 'campaign_analytics' does not exist!")
                return False

            # Get table structure
            cursor.execute("DESCRIBE campaign_analytics")
            columns = cursor.fetchall()
            print(f"✅ Table 'campaign_analytics' exists with {len(columns)} columns:")
            for col in columns[:10]:  # Show first 10 columns
                print(f"  - {col['Field']}: {col['Type']}")
            if len(columns) > 10:
                print(f"  ... and {len(columns) - 10} more columns")

            # Count records
            cursor.execute("SELECT COUNT(*) as total FROM campaign_analytics")
            count_result = cursor.fetchone()
            total_records = count_result['total']
            print(f"✅ Total records in campaign_analytics: {total_records}")

            return total_records > 0
    except Exception as e:
        print(f"❌ Database test failed: {e}")
        return False
    finally:
        connection.close()

# Training data configuration
TRAINING_MIN_SAMPLES = 5  # Minimum samples needed for training
VALID_ENGAGEMENT_THRESHOLD = 0  # Minimum total engagement (reactions + comments + shares)
CONTENT_REQUIRED = True  # Whether post content is required for training
