INSERT INTO
    posts (user_id, title, content)
VALUES
    (
        1,
        SUBSTRING(
            MD5 (RAND ())
            FROM
                1 FOR 10
        ),
        SUBSTRING(
            MD5 (RAND ())
            FROM
                1 FOR 100
        )
    ),
    (
        2,
        SUBSTRING(
            MD5 (RAND ())
            FROM
                1 FOR 10
        ),
        SUBSTRING(
            MD5 (RAND ())
            FROM
                1 FOR 100
        )
    ),
    (
        3,
        SUBSTRING(
            MD5 (RAND ())
            FROM
                1 FOR 10
        ),
        SUBSTRING(
            MD5 (RAND ())
            FROM
                1 FOR 100
        )
    ),
    (
        4,
        SUBSTRING(
            MD5 (RAND ())
            FROM
                1 FOR 10
        ),
        SUBSTRING(
            MD5 (RAND ())
            FROM
                1 FOR 100
        )
    ),