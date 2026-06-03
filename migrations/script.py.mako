"""${message}

Revision ID: ${up_revision}
Revises: ${down_revision | comma,n}
Create Date: ${create_date}
"""

from alembic import op
import sqlalchemy as sa
${imports if imports else ""}

# -------------------------------------------------
# Revision metadata
# -------------------------------------------------
revision = ${repr(up_revision)}
down_revision = ${repr(down_revision)}
branch_labels = ${repr(branch_labels)}
depends_on = ${repr(depends_on)}

# -------------------------------------------------
# Upgrade
# -------------------------------------------------
def upgrade() -> None:
    """
    Apply schema changes safely.
    """
    try:
        ${upgrades if upgrades else "pass"}
    except Exception as e:
        raise RuntimeError(f"Upgrade failed: {e}")


# -------------------------------------------------
# Downgrade
# -------------------------------------------------
def downgrade() -> None:
    """
    Revert schema changes safely.
    """
    try:
        ${downgrades if downgrades else "pass"}
    except Exception as e:
        raise RuntimeError(f"Downgrade failed: {e}")
